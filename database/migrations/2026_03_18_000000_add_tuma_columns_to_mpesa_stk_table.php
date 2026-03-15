<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('mpesa_s_t_k_s', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('phonenumber');
            $table->string('payment_id')->nullable()->after('order_id');
            $table->unsignedBigInteger('invoice_id')->nullable()->after('payment_id');
            $table->string('status')->nullable()->after('invoice_id');
            $table->string('customer_name')->nullable()->after('status');
            $table->json('payload')->nullable()->after('customer_name');
            $table->foreign('invoice_id')->references('id')->on('invoices')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('mpesa_s_t_k_s', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['payload', 'customer_name', 'status', 'invoice_id', 'payment_id', 'order_id']);
        });
    }
};
