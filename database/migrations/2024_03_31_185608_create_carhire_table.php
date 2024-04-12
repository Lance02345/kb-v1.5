<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarhireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carhire', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('city');
            $table->unsignedBigInteger('model_id');
            $table->integer('year_of_build');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->text('description');
            $table->string('body_type');
            $table->string('color');
            $table->string('front_img');
            $table->string('back_img');
            $table->string('right_img');
            $table->string('left_img');
            $table->string('interiorf_img');
            $table->string('interiorb_img');
            $table->string('opt_img1')->nullable();
            $table->string('opt_img2')->nullable();
            $table->string('opt_img3')->nullable();
            $table->date('pickup_date')->nullable();
            $table->date('return_date')->nullable();
            $table->unsignedBigInteger('user_id'); // Assuming you want to associate each car hire with a user
            $table->unsignedBigInteger('package_id');
            $table->integer('rent_days');
            $table->decimal('price_per_day', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carhire');
    }
}

