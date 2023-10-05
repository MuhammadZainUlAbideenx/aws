<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('session_token', 255)->nullable();
            $table->bigInteger('order_id');
            $table->string('order_number', 100)->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('variant', 255)->nullable();
            $table->string('sale_type', 255)->nullable();
            $table->float('sale_price_current', 10, 0);
            $table->float('total_sale_price_current', 10, 0);
            $table->float('single_price_current', 10, 0);
            $table->float('total_price_current', 10, 0);
            $table->float('single_price_default', 10, 0);
            $table->float('total_price_default', 10, 0);
            $table->integer('commission_type')->nullable()->comment('0 for category, 1
 for sale commission');
            $table->integer('commission_rate_type')->nullable()->comment('1 for percentage, 2 for fixed');
            $table->string('commission_rate', 100)->nullable();
            $table->float('commission_amount', 10, 0)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
