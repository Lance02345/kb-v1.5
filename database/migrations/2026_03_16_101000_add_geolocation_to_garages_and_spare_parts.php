<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('garages')) {
            Schema::table('garages', function (Blueprint $table) {
                if (!Schema::hasColumn('garages', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('garage_location');
                }
                if (!Schema::hasColumn('garages', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
            });
        }

        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (!Schema::hasColumn('spare_parts', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('location');
                }
                if (!Schema::hasColumn('spare_parts', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('garages')) {
            Schema::table('garages', function (Blueprint $table) {
                if (Schema::hasColumn('garages', 'longitude')) {
                    $table->dropColumn('longitude');
                }
                if (Schema::hasColumn('garages', 'latitude')) {
                    $table->dropColumn('latitude');
                }
            });
        }

        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (Schema::hasColumn('spare_parts', 'longitude')) {
                    $table->dropColumn('longitude');
                }
                if (Schema::hasColumn('spare_parts', 'latitude')) {
                    $table->dropColumn('latitude');
                }
            });
        }
    }
};
