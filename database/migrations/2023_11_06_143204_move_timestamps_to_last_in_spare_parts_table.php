<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveTimestampsToLastInSparePartsTable extends Migration
{
    public function up()
    {
        $hasCreatedAt = Schema::hasColumn('spare_parts', 'created_at');
        $hasUpdatedAt = Schema::hasColumn('spare_parts', 'updated_at');

        if ($hasCreatedAt && $hasUpdatedAt) {
            return;
        }

        Schema::table('spare_parts', function (Blueprint $table) use ($hasCreatedAt, $hasUpdatedAt) {
            if (!$hasCreatedAt) {
                $table->timestamp('created_at')->nullable();
            }

            if (!$hasUpdatedAt) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down()
    {
        // No-op: this migration is only a compatibility shim for timestamp columns.
    }
}
