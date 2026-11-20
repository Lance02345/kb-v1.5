<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Adds every car make and model from database/data/car_makes_models_recommended.csv
 * (built by database/data/build_car_catalog.py from NHTSA vPIC + Wikidata).
 *
 * Safe to run any number of times, including on production:
 *   - only inserts makes/models that are not already present (case- and dash-insensitive match)
 *   - never updates or deletes existing rows, so ids referenced by listings stay valid
 *
 *   php artisan db:seed --class=CarCatalogSeeder --force
 */
class CarCatalogSeeder extends Seeder
{
    private const CSV = 'data/car_makes_models_recommended.csv';

    public function run(): void
    {
        $rows = $this->readCsv(database_path(self::CSV));

        DB::transaction(function () use ($rows) {
            $makeIds = $this->ensureMakes(array_unique(array_column($rows, 'make')));
            $added = $this->insertMissingModels($rows, $makeIds);

            $this->command?->info(sprintf(
                'Car catalogue: %d makes (%d new), %d new models added.',
                count($makeIds),
                $this->newMakes,
                $added
            ));
        });
    }

    private int $newMakes = 0;

    /**
     * @return array<string, int> normalised make name => carmakes.id
     */
    private function ensureMakes(array $makes): array
    {
        $existing = [];
        foreach (DB::table('carmakes')->get(['id', 'make']) as $row) {
            $existing[$this->key($row->make)] ??= $row->id;
        }

        $now = now();
        foreach ($makes as $make) {
            $key = $this->key($make);
            if (!isset($existing[$key])) {
                $existing[$key] = DB::table('carmakes')->insertGetId([
                    'make' => $make,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $this->newMakes++;
            }
        }

        return $existing;
    }

    private function insertMissingModels(array $rows, array $makeIds): int
    {
        $existing = [];
        foreach (DB::table('carmodels')->get(['make_id', 'model']) as $row) {
            $existing[$row->make_id . '|' . $this->key($row->model)] = true;
        }

        $now = now();
        $batch = [];
        foreach ($rows as $row) {
            $makeId = $makeIds[$this->key($row['make'])];
            $key = $makeId . '|' . $this->key($row['model']);
            if (isset($existing[$key])) {
                continue;
            }
            $existing[$key] = true;
            $batch[] = [
                'model' => $row['model'],
                'make_id' => $makeId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($batch, 500) as $chunk) {
            DB::table('carmodels')->insert($chunk);
        }

        return count($batch);
    }

    /** "Mercedes Benz" / "mercedes-benz" and "Škoda" / "Skoda" / "Citroën" / "Citroen" all match. */
    private function key(?string $name): string
    {
        $name = mb_strtolower(Str::ascii(trim((string) $name)));

        return preg_replace('/[\s\-_]+/u', ' ', $name);
    }

    /**
     * @return list<array{make: string, model: string}>
     */
    private function readCsv(string $path): array
    {
        if (!is_readable($path)) {
            throw new RuntimeException("Car catalogue CSV not found: {$path}");
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $rows = [];
        while (($line = fgetcsv($handle)) !== false) {
            $row = array_combine($header, $line);
            if (trim($row['make']) !== '' && trim($row['model']) !== '') {
                $rows[] = ['make' => trim($row['make']), 'model' => trim($row['model'])];
            }
        }
        fclose($handle);

        return $rows;
    }
}
