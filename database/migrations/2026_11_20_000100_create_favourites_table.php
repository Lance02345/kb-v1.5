<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The favourites table (App\Models\Favourites) exists in production but was never
     * captured in a migration. Guarded so it is a no-op wherever the table already exists.
     */
    public function up(): void
    {
        if (Schema::hasTable('favourites')) {
            return;
        }

        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('vehicle_id')->nullable()->index();
            $table->unsignedBigInteger('listing_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // No-op: never drop a table that may hold production data.
    }
};
