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
                if (!Schema::hasColumn('garages', 'location_normalized')) {
                    $table->string('location_normalized')->nullable()->after('garage_location');
                }
            });
        }

        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (!Schema::hasColumn('spare_parts', 'location_normalized')) {
                    $table->string('location_normalized')->nullable()->after('location');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('garages')) {
            Schema::table('garages', function (Blueprint $table) {
                if (Schema::hasColumn('garages', 'location_normalized')) {
                    $table->dropColumn('location_normalized');
                }
            });
        }

        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (Schema::hasColumn('spare_parts', 'location_normalized')) {
                    $table->dropColumn('location_normalized');
                }
            });
        }
    }
};
