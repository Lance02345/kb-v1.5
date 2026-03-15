<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Garage;
use App\Models\SparePart;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class NormalizeLocations extends Command
{
    protected $signature = 'listings:normalize-locations {--dry-run : Do not persist changes}';
    protected $description = 'Normalize location text and backfill coordinates for garages and spare parts';

    public function handle(): int
    {
        $models = [
            Garage::class => ['column' => 'garage_location', 'label' => 'Garage'],
            SparePart::class => ['column' => 'location', 'label' => 'Spare part'],
        ];

        $dryRun = $this->option('dry-run');
        $cities = City::query()->orderBy('city')->get(['city', 'latitude', 'longitude']);
        if ($cities->isEmpty()) {
            $this->warn('No cities found. Seed the cities table with coordinates before running this command.');
        }

        foreach ($models as $modelClass => $config) {
            $this->info("Processing {$config['label']} records...");

            $query = $modelClass::query();
            $query->chunkById(200, function ($records) use ($modelClass, $config, $cities, $dryRun) {
                foreach ($records as $record) {
                    $value = Str::of($record->{$config['column']} ?? '')->trim();
                    if ($value->isEmpty()) {
                        continue;
                    }

                    $normalized = $this->normalizeText($value->toString());
                    $city = $this->findMatchingCity($cities, $normalized);

                    $update = [];
                    if ($record->location_normalized !== $normalized) {
                        $update['location_normalized'] = $normalized;
                    }

                    if ($city) {
                        if ($record->latitude === null && $city->latitude !== null) {
                            $update['latitude'] = $city->latitude;
                        }
                        if ($record->longitude === null && $city->longitude !== null) {
                            $update['longitude'] = $city->longitude;
                        }
                    }

                    if (empty($update)) {
                        continue;
                    }

                    if ($dryRun) {
                        $this->line("[dry-run] {$config['label']} #{$record->id} -> " . json_encode($update));
                        continue;
                    }

                    $record->fill($update);
                    $record->save();
                    $this->info("Updated {$config['label']} #{$record->id}");
                }
            });
        }

        $this->info('Location normalization complete.');

        return 0;
    }

    private function normalizeText(string $value): string
    {
        $clean = Str::of($value)
            ->lower()
            ->replaceMatches('/[^a-z0-9\s]/', ' ')
            ->trim()
            ->replaceMatches('/\s+/', ' ')
            ->title();

        return $clean->toString();
    }

    private function findMatchingCity($cities, string $normalized)
    {
        $needle = Str::lower($normalized);
        $parts = array_filter(preg_split('/[\s,]+/', $needle));

        foreach ($cities as $city) {
            $cityName = Str::lower($city->city);

            if ($cityName === $needle) {
                return $city;
            }

            if (Str::contains($needle, $cityName)) {
                return $city;
            }

            foreach ($parts as $part) {
                if ($part === $cityName) {
                    return $city;
                }
            }
        }

        return null;
    }
}
