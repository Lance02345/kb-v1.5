<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToSpareParts extends Migration
{
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
