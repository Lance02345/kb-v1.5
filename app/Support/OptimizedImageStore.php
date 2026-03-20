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

        $inputPath = $image->getRealPath() ?: $image->path();
        $memoryGuard = $this->canSafelyDecode($inputPath);

        if (!$memoryGuard['allowed']) {
            $originalExtension = strtolower($image->getClientOriginalExtension() ?: 'jpg');
            $fallbackFileName = $baseName . '.' . $originalExtension;
            $fallbackRelativePath = $this->joinPath($directory, $fallbackFileName);

            $image->storeAs($directory, $fallbackFileName, 'public');

            return $fallbackRelativePath;
        }

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

        $memoryGuard = $this->canSafelyDecode($absolutePath);
        if (!$memoryGuard['allowed']) {
            return [
                'status' => 'skipped',
                'reason' => 'memory_guard',
                'required_bytes' => $memoryGuard['required_bytes'] ?? null,
                'available_bytes' => $memoryGuard['available_bytes'] ?? null,
            ];
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

    private function canSafelyDecode(?string $path): array
    {
        if (!$path || !is_file($path)) {
            return ['allowed' => false, 'reason' => 'file_not_found'];
        }

        $info = @getimagesize($path);
        if ($info === false) {
            return ['allowed' => false, 'reason' => 'unreadable_image'];
        }

        $width = (int) ($info[0] ?? 0);
        $height = (int) ($info[1] ?? 0);
        $bits = (int) ($info['bits'] ?? 8);
        $channels = (int) ($info['channels'] ?? 4);

        if ($width <= 0 || $height <= 0) {
            return ['allowed' => false, 'reason' => 'invalid_dimensions'];
        }

        // Conservative estimate for GD decode + resize overhead.
        $requiredBytes = (int) ceil(($width * $height * max($bits, 8) * max($channels, 3) / 8) * 5);
        $memoryLimit = $this->parseIniBytes((string) ini_get('memory_limit'));
        $currentUsage = memory_get_usage(true);

        if ($memoryLimit > 0) {
            $availableBytes = max(0, $memoryLimit - $currentUsage);
            // Keep a safety buffer so shared hosting does not hit the ceiling.
            $safeBudget = (int) floor($availableBytes * 0.7);

            if ($requiredBytes > $safeBudget) {
                return [
                    'allowed' => false,
                    'reason' => 'memory_guard',
                    'required_bytes' => $requiredBytes,
                    'available_bytes' => $safeBudget,
                ];
            }

            return [
                'allowed' => true,
                'required_bytes' => $requiredBytes,
                'available_bytes' => $safeBudget,
            ];
        }

        return ['allowed' => true, 'required_bytes' => $requiredBytes, 'available_bytes' => null];
    }

    private function parseIniBytes(string $value): int
    {
        $value = trim($value);
        if ($value === '' || $value === '-1') {
            return -1;
        }

        $unit = strtolower(substr($value, -1));
        $number = (float) $value;

        return match ($unit) {
            'g' => (int) round($number * 1024 * 1024 * 1024),
            'm' => (int) round($number * 1024 * 1024),
            'k' => (int) round($number * 1024),
            default => (int) round($number),
        };
    }
}
