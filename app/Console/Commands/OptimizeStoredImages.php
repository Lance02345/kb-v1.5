<?php

namespace App\Console\Commands;

use App\Support\OptimizedImageStore;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeStoredImages extends Command
{
    protected $signature = 'images:optimize-existing
                            {--execute : Actually rewrite files instead of running a dry-run}
                            {--backup : Save a .bak copy before replacing the original file}
                            {--restore : Restore original files from existing .bak backups}
                            {--directory=* : Public disk directories to scan. Defaults to photos and garages}
                            {--limit=0 : Stop after this many files (0 = no limit)}
                            {--max-dimension=1600 : Maximum width/height for optimized images}
                            {--quality=82 : JPEG/WEBP quality for optimized images}';

    protected $description = 'Dry-run, optimize, or restore existing stored listing images in place without changing file paths.';

    public function handle(OptimizedImageStore $optimizedImageStore): int
    {
        $directories = array_values(array_filter($this->option('directory') ?: ['photos', 'garages']));
        $execute = (bool) $this->option('execute');
        $backup = (bool) $this->option('backup');
        $restore = (bool) $this->option('restore');
        $limit = max(0, (int) $this->option('limit'));
        $maxDimension = max(400, (int) $this->option('max-dimension'));
        $quality = max(40, min(95, (int) $this->option('quality')));

        if ($restore && $backup) {
            $this->error('Use either --restore or --backup, not both.');
            return self::FAILURE;
        }

        if ($restore && !$execute) {
            $this->warn('Restore mode changes files too. Re-run with --restore --execute to continue.');
            return self::SUCCESS;
        }

        if ($restore) {
            return $this->restoreBackups($directories, $limit);
        }

        $files = collect();
        foreach ($directories as $directory) {
            if (Storage::disk('public')->exists($directory)) {
                $files = $files->concat(Storage::disk('public')->allFiles($directory));
            }
        }

        $files = $files->unique()->values();
        if ($limit > 0) {
            $files = $files->take($limit);
        }

        if ($files->isEmpty()) {
            $this->warn('No files found in the selected directories.');
            return self::SUCCESS;
        }

        $this->line(($execute ? 'Executing' : 'Dry-run') . ' optimization for ' . $files->count() . ' files.');

        $summary = [
            'ready' => 0,
            'optimized' => 0,
            'skipped' => 0,
            'errors' => 0,
            'bytes_saved' => 0,
        ];

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        foreach ($files as $relativePath) {
            $result = $optimizedImageStore->optimizeExistingPublicFile($relativePath, $maxDimension, $quality);

            if ($result['status'] === 'ready') {
                $summary['ready']++;

                if ($execute) {
                    try {
                        if ($backup) {
                            @copy($result['absolute_path'], $result['absolute_path'] . '.bak');
                        }

                        if (!@copy($result['temp_path'], $result['absolute_path'])) {
                            throw new \RuntimeException('Failed to overwrite original file.');
                        }

                        @unlink($result['temp_path']);

                        $summary['optimized']++;
                        $summary['bytes_saved'] += max(0, $result['original_size'] - $result['optimized_size']);
                    } catch (\Throwable $exception) {
                        @unlink($result['temp_path']);
                        $summary['errors']++;
                        $this->newLine();
                        $this->error("Failed to optimize {$relativePath}: {$exception->getMessage()}");
                    }
                } else {
                    $summary['bytes_saved'] += max(0, $result['original_size'] - $result['optimized_size']);
                    @unlink($result['temp_path']);
                }
            } else {
                $summary['skipped']++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Optimization summary:');
        $this->line('Mode: ' . ($execute ? 'execute' : 'dry-run'));
        $this->line('Files scanned: ' . $files->count());
        $this->line('Optimizable files: ' . $summary['ready']);
        $this->line('Files optimized: ' . $summary['optimized']);
        $this->line('Files skipped: ' . $summary['skipped']);
        $this->line('Errors: ' . $summary['errors']);
        $this->line('Estimated bytes saved: ' . number_format($summary['bytes_saved']));

        if (!$execute) {
            $this->comment('Dry-run only. Re-run with --execute to apply the changes.');
        }

        return $summary['errors'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function restoreBackups(array $directories, int $limit): int
    {
        $disk = Storage::disk('public');
        $backupFiles = collect();

        foreach ($directories as $directory) {
            if ($disk->exists($directory)) {
                $backupFiles = $backupFiles->concat(
                    collect($disk->allFiles($directory))->filter(fn ($path) => str_ends_with($path, '.bak'))
                );
            }
        }

        $backupFiles = $backupFiles->unique()->values();
        if ($limit > 0) {
            $backupFiles = $backupFiles->take($limit);
        }

        if ($backupFiles->isEmpty()) {
            $this->warn('No backup files found in the selected directories.');
            return self::SUCCESS;
        }

        $this->line('Restoring ' . $backupFiles->count() . ' backup files.');

        $restored = 0;
        $errors = 0;
        $bar = $this->output->createProgressBar($backupFiles->count());
        $bar->start();

        foreach ($backupFiles as $backupRelativePath) {
            $backupAbsolutePath = $disk->path($backupRelativePath);
            $originalRelativePath = substr($backupRelativePath, 0, -4);
            $originalAbsolutePath = $disk->path($originalRelativePath);

            try {
                if (!@copy($backupAbsolutePath, $originalAbsolutePath)) {
                    throw new \RuntimeException('Failed to restore backup.');
                }

                $restored++;
            } catch (\Throwable $exception) {
                $errors++;
                $this->newLine();
                $this->error("Failed to restore {$backupRelativePath}: {$exception->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Restore summary:');
        $this->line('Backups scanned: ' . $backupFiles->count());
        $this->line('Files restored: ' . $restored);
        $this->line('Errors: ' . $errors);

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }
}
