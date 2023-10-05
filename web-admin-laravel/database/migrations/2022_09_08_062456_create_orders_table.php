<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number', 255);
            $table->string('parent_order_id', 50)->nullable();
            $table->integer('vendor_id')->nullable();
            $table->bigInteger('order_status_id');
            $table->string('order_status_reason')->nullable();
            $table->bigInteger('payment_method_id');
            $table->string('transaction_id', 255)->nullable();
            $table->bigInteger('shipping_method_id');
            $table->bigInteger('customer_id');
            $table->integer('is_active');
            $table->boolean('is_paid')->default(false);
            $table->string('transaction_status', 255);
            $table->float('total', 10, 0);
            $table->float('current_currency_sub_total', 10, 0);
            $table->float('current_currency_shipping_price', 10, 0);
            $table->float('current_currency_value', 10, 0);
            $table->float('sub_total', 10, 0);
            $table->float('shipping_price', 10, 0)->nullable();
            $table->integer('is_coupon_applied')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('coupon_amount', 10, 0)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('rider_id')->nullable();
            $table->string('current_currency', 255);
            $table->float('current_currency_total', 10, 0);
            $table->string('default_currency_total', 255);
            $table->string('default_currency', 255);
            $table->float('default_currency_value', 10, 0);
            $table->integer('commission_type')->nullable()->comment('0 for category, 1 for sale commission');
            $table->float('commission_amount', 10, 0)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
