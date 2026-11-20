<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The garages table exists in production but was never captured in a migration.
     * Guarded so it is a no-op wherever the table already exists.
     */
    public function up(): void
    {
        if (Schema::hasTable('garages')) {
            return;
        }

        Schema::create('garages', function (Blueprint $table) {
            $table->id();
            $table->string('garage_title')->nullable();
            $table->string('garage_location')->nullable();
            $table->string('location_normalized')->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('garage_description')->nullable();
            $table->string('front_img')->nullable();
            $table->string('back_img')->nullable();
            $table->string('right_img')->nullable();
            $table->string('left_img')->nullable();
            $table->string('interiorf_img')->nullable();
            $table->string('interiorb_img')->nullable();
            $table->string('opt_img1')->nullable();
            $table->string('opt_img2')->nullable();
            $table->string('opt_img3')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('listing_id')->nullable()->index();
            $table->unsignedBigInteger('invoice_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // No-op: never drop a table that may hold production data.
    }
};
