<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OptimizedImageStore
{
    private const MAX_DIMENSION = 1600;
    private const JPEG_QUALITY = 82;
    private const SUPPORTED_EXISTING_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    public function defaultMaxDimension(): int
    {
        return self::MAX_DIMENSION;
    }

    public function defaultQuality(): int
    {
        return self::JPEG_QUALITY;
    }

    public function storePublicImage(UploadedFile $image, string $directory, string $fieldPrefix, ?string $watermarkPath = null): string
    {
        $directory = trim($directory, '/');
        $baseName = $fieldPrefix . '_' . time() . '_' . uniqid();
        $optimizedFileName = $baseName . '.jpg';
        $relativePath = $this->joinPath($directory, $optimizedFileName);

        Storage::disk('public')->makeDirectory($directory);

        try {
            $img = Image::make($image)->orientate();
            $img->resize(self::MAX_DIMENSION, self::MAX_DIMENSION, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if ($watermarkPath && file_exists($watermarkPath)) {
                $watermark = Image::make($watermarkPath);
                $maxWatermarkWidth = max(80, (int) round($img->width() * 0.18));
                $maxWatermarkHeight = max(40, (int) round($img->height() * 0.18));

                $watermark->resize($maxWatermarkWidth, $maxWatermarkHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->insert($watermark, 'bottom-right', 16, 16);
            }

            $img->interlace();
            $img->save(Storage::disk('public')->path($relativePath), self::JPEG_QUALITY, 'jpg');

            return $relativePath;
        } catch (\Throwable $exception) {
            $originalExtension = strtolower($image->getClientOriginalExtension() ?: 'jpg');
            $fallbackFileName = $baseName . '.' . $originalExtension;
            $fallbackRelativePath = $this->joinPath($directory, $fallbackFileName);

            $image->storeAs($directory, $fallbackFileName, 'public');

            return $fallbackRelativePath;
        }
    }

    public function optimizeExistingPublicFile(string $relativePath, int $maxDimension = self::MAX_DIMENSION, int $quality = self::JPEG_QUALITY): array
    {
        $disk = Storage::disk('public');

        if (!$disk->exists($relativePath)) {
            return ['status' => 'missing', 'reason' => 'file_not_found'];
        }

        $absolutePath = $disk->path($relativePath);
        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        if (!in_array($extension, self::SUPPORTED_EXISTING_EXTENSIONS, true)) {
            return ['status' => 'skipped', 'reason' => 'unsupported_extension'];
        }

        $originalSize = @filesize($absolutePath) ?: 0;

        try {
            $image = Image::make($absolutePath)->orientate();
        } catch (\Throwable $exception) {
            return ['status' => 'skipped', 'reason' => 'unreadable_image'];
        }

        $originalWidth = $image->width();
        $originalHeight = $image->height();
        $resized = false;

        if ($originalWidth > $maxDimension || $originalHeight > $maxDimension) {
            $image->resize($maxDimension, $maxDimension, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $resized = true;
        }

        $tmpPath = $absolutePath . '.optimize_tmp';
        $format = $extension === 'jpg' ? 'jpeg' : $extension;

        try {
            if ($extension === 'png') {
                $image->save($tmpPath, 9, 'png');
            } else {
                $image->save($tmpPath, $quality, $format);
            }
        } catch (\Throwable $exception) {
            if (file_exists($tmpPath)) {
                @unlink($tmpPath);
            }

            return ['status' => 'skipped', 'reason' => 'write_failed'];
        }

        $optimizedSize = @filesize($tmpPath) ?: 0;
        $optimizedWidth = $image->width();
        $optimizedHeight = $image->height();

        $shouldReplace = $optimizedSize > 0
            && $optimizedSize < $originalSize
            && ($resized || $optimizedSize !== $originalSize);

        if (!$shouldReplace) {
            @unlink($tmpPath);

            return [
                'status' => 'skipped',
                'reason' => $resized ? 'not_smaller_after_resize' : 'already_optimized',
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
                'original_width' => $originalWidth,
                'original_height' => $originalHeight,
                'optimized_width' => $optimizedWidth,
                'optimized_height' => $optimizedHeight,
            ];
        }

        return [
            'status' => 'ready',
            'temp_path' => $tmpPath,
            'absolute_path' => $absolutePath,
            'original_size' => $originalSize,
            'optimized_size' => $optimizedSize,
            'original_width' => $originalWidth,
            'original_height' => $originalHeight,
            'optimized_width' => $optimizedWidth,
            'optimized_height' => $optimizedHeight,
        ];
    }

    private function joinPath(string $directory, string $fileName): string
    {
        return $directory === '' ? $fileName : $directory . '/' . $fileName;
    }
}
