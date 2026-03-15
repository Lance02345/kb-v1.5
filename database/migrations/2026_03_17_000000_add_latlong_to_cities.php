<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cities')) {
            Schema::table('cities', function (Blueprint $table) {
                if (!Schema::hasColumn('cities', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('city');
                }
                if (!Schema::hasColumn('cities', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cities')) {
            Schema::table('cities', function (Blueprint $table) {
                if (Schema::hasColumn('cities', 'longitude')) {
                    $table->dropColumn('longitude');
                }
                if (Schema::hasColumn('cities', 'latitude')) {
                    $table->dropColumn('latitude');
                }
            });
        }
    }
};
