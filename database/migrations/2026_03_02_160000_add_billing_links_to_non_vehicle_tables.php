<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingLinksToNonVehicleTables extends Migration
{
    public function up()
    {
        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (!Schema::hasColumn('spare_parts', 'listing_id')) {
                    $table->unsignedBigInteger('listing_id')->nullable()->after('user_id');
                    $table->foreign('listing_id')->references('id')->on('listings')->nullOnDelete();
                }
                if (!Schema::hasColumn('spare_parts', 'invoice_id')) {
                    $table->unsignedBigInteger('invoice_id')->nullable()->after('listing_id');
                    $table->foreign('invoice_id')->references('id')->on('invoices')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('garages')) {
            Schema::table('garages', function (Blueprint $table) {
                if (!Schema::hasColumn('garages', 'listing_id')) {
                    $table->unsignedBigInteger('listing_id')->nullable()->after('user_id');
                    $table->foreign('listing_id')->references('id')->on('listings')->nullOnDelete();
                }
                if (!Schema::hasColumn('garages', 'invoice_id')) {
                    $table->unsignedBigInteger('invoice_id')->nullable()->after('listing_id');
                    $table->foreign('invoice_id')->references('id')->on('invoices')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('carevents')) {
            Schema::table('carevents', function (Blueprint $table) {
                if (!Schema::hasColumn('carevents', 'listing_id')) {
                    $table->unsignedBigInteger('listing_id')->nullable()->after('user_id');
                    $table->foreign('listing_id')->references('id')->on('listings')->nullOnDelete();
                }
                if (!Schema::hasColumn('carevents', 'invoice_id')) {
                    $table->unsignedBigInteger('invoice_id')->nullable()->after('listing_id');
                    $table->foreign('invoice_id')->references('id')->on('invoices')->nullOnDelete();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('spare_parts')) {
            Schema::table('spare_parts', function (Blueprint $table) {
                if (Schema::hasColumn('spare_parts', 'invoice_id')) {
                    $table->dropForeign(['invoice_id']);
                    $table->dropColumn('invoice_id');
                }
                if (Schema::hasColumn('spare_parts', 'listing_id')) {
                    $table->dropForeign(['listing_id']);
                    $table->dropColumn('listing_id');
                }
            });
        }

        if (Schema::hasTable('garages')) {
            Schema::table('garages', function (Blueprint $table) {
                if (Schema::hasColumn('garages', 'invoice_id')) {
                    $table->dropForeign(['invoice_id']);
                    $table->dropColumn('invoice_id');
                }
                if (Schema::hasColumn('garages', 'listing_id')) {
                    $table->dropForeign(['listing_id']);
                    $table->dropColumn('listing_id');
                }
            });
        }

        if (Schema::hasTable('carevents')) {
            Schema::table('carevents', function (Blueprint $table) {
                if (Schema::hasColumn('carevents', 'invoice_id')) {
                    $table->dropForeign(['invoice_id']);
                    $table->dropColumn('invoice_id');
                }
                if (Schema::hasColumn('carevents', 'listing_id')) {
                    $table->dropForeign(['listing_id']);
                    $table->dropColumn('listing_id');
                }
            });
        }
    }
}
