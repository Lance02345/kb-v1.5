<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCategoryToSparePartsTable extends Migration
{
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            if (!Schema::hasColumn('spare_parts', 'category')) {
                $table->string('category')->nullable()->after('id')->index();
            }
        });

        DB::table('spare_parts')
            ->where(function ($query) {
                $query->whereNull('category')
                    ->orWhere('category', '');
            })
            ->update(['category' => 'Other']);
    }

    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            if (Schema::hasColumn('spare_parts', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
}
