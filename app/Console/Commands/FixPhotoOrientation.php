<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FixPhotoOrientation extends Command
{
    protected $signature = 'photos:fix-orientation
        {--path=storage/app/public/photos : Relative or absolute directory to scan}
        {--limit=0 : Maximum number of files to process (0 = all)}
        {--dry-run : Show what would be changed without writing files}';

    protected $description = 'Fix EXIF orientation for existing photos saved on disk';

    public function handle(): int
    {
        $pathOption = (string) $this->option('path');
        $basePath = str_starts_with($pathOption, DIRECTORY_SEPARATOR)
            ? $pathOption
            : base_path($pathOption);

        if (!File::isDirectory($basePath)) {
            $this->error("Directory not found: {$basePath}");
            return self::FAILURE;
        }

        $limit = max(0, (int) $this->option('limit'));
        $dryRun = (bool) $this->option('dry-run');
        $allowedExtensions = ['jpg', 'jpeg', 'heic', 'heif'];

        $files = collect(File::allFiles($basePath))
            ->filter(function ($file) use ($allowedExtensions) {
                $ext = strtolower($file->getExtension());
                return in_array($ext, $allowedExtensions, true);
            })
            ->values();

        if ($limit > 0) {
            $files = $files->take($limit)->values();
        }

        $fixed = 0;
        $skipped = 0;
        $failed = 0;

        $this->info('Scanning: ' . $basePath);
        $this->info('Candidate files: ' . $files->count());
        if ($dryRun) {
            $this->comment('Dry run mode enabled. No files will be changed.');
        }

        foreach ($files as $file) {
            $filePath = $file->getPathname();

            try {
                $orientation = $this->readExifOrientation($filePath);

                if ($orientation === null || $orientation === 1) {
                    $skipped++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("Would fix: {$filePath} (EXIF orientation: {$orientation})");
                    $fixed++;
                    continue;
                }

                Image::make($filePath)
                    ->orientate()
                    ->save($filePath, 90);

                $this->line("Fixed: {$filePath} (EXIF orientation: {$orientation})");
                $fixed++;
            } catch (\Throwable $e) {
                $failed++;
                $this->warn("Failed: {$filePath} ({$e->getMessage()})");
            }
        }

        $this->newLine();
        $this->info("Done. Fixed: {$fixed}, Skipped: {$skipped}, Failed: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function readExifOrientation(string $path): ?int
    {
        if (!function_exists('exif_read_data')) {
            return null;
        }

        $exif = @exif_read_data($path);
        if (!is_array($exif)) {
            return null;
        }

        if (isset($exif['Orientation'])) {
            return (int) $exif['Orientation'];
        }

        return null;
    }
}

