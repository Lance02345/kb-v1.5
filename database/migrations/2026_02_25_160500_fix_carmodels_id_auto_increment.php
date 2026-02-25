<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ensure carmodels.id is an AUTO_INCREMENT primary key.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $databaseName = DB::getDatabaseName();
        $column = DB::selectOne(
            'SELECT COLUMN_KEY AS column_key, EXTRA AS extra, COLUMN_TYPE AS column_type
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?
             LIMIT 1',
            [$databaseName, 'carmodels', 'id']
        );

        if (!$column) {
            return;
        }

        $isPrimary = strtoupper((string) $column->column_key) === 'PRI';
        $isAutoIncrement = stripos((string) $column->extra, 'auto_increment') !== false;

        if (!$isPrimary) {
            DB::statement('ALTER TABLE `carmodels` ADD PRIMARY KEY (`id`)');
        }

        if (!$isAutoIncrement) {
            $columnType = (string) $column->column_type;
            DB::statement("ALTER TABLE `carmodels` MODIFY `id` {$columnType} NOT NULL AUTO_INCREMENT");
        }
    }

    /**
     * Reverse migration.
     */
    public function down(): void
    {
        // No-op: we do not want to remove primary key/auto_increment from production data.
    }
};

