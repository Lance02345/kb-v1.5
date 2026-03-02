<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreImagesToSparePartsTable extends Migration
{
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            if (!Schema::hasColumn('spare_parts', 'left_img')) {
                $table->string('left_img')->nullable()->after('right_img');
            }
            if (!Schema::hasColumn('spare_parts', 'interiorf_img')) {
                $table->string('interiorf_img')->nullable()->after('left_img');
            }
            if (!Schema::hasColumn('spare_parts', 'interiorb_img')) {
                $table->string('interiorb_img')->nullable()->after('interiorf_img');
            }
            if (!Schema::hasColumn('spare_parts', 'opt_img1')) {
                $table->string('opt_img1')->nullable()->after('interiorb_img');
            }
            if (!Schema::hasColumn('spare_parts', 'opt_img2')) {
                $table->string('opt_img2')->nullable()->after('opt_img1');
            }
            if (!Schema::hasColumn('spare_parts', 'opt_img3')) {
                $table->string('opt_img3')->nullable()->after('opt_img2');
            }
        });
    }

    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $dropColumns = array_filter([
                Schema::hasColumn('spare_parts', 'left_img') ? 'left_img' : null,
                Schema::hasColumn('spare_parts', 'interiorf_img') ? 'interiorf_img' : null,
                Schema::hasColumn('spare_parts', 'interiorb_img') ? 'interiorb_img' : null,
                Schema::hasColumn('spare_parts', 'opt_img1') ? 'opt_img1' : null,
                Schema::hasColumn('spare_parts', 'opt_img2') ? 'opt_img2' : null,
                Schema::hasColumn('spare_parts', 'opt_img3') ? 'opt_img3' : null,
            ]);

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
}
