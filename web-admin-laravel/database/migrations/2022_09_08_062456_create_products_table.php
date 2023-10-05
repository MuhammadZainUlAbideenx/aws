<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id')->nullable()->index('shop_id');
            $table->longText('name');
            $table->longText('description');
            $table->longText('short_description')->nullable();
            $table->longText('refund_policy')->nullable();
            $table->integer('product_type');
            $table->string('modal', 255)->nullable();
            $table->boolean('is_feature');
            $table->decimal('price', 15, 6);
            $table->string('sku', 255)->nullable();
            $table->integer('stock')->nullable()->default(10);
            $table->integer('quantity');
            $table->string('available_date', 255)->nullable();
            $table->string('weight');
            $table->integer('unit_id');
            $table->tinyInteger('is_active');
            $table->integer('manufacturer_id');
            $table->integer('brand_id')->nullable();
            $table->integer('tax_class_id');
            $table->integer('product_ordered')->default(0);
            $table->integer('product_liked')->default(0);
            $table->string('slug', 255)->nullable();
            $table->string('external_link', 255)->nullable();
            $table->integer('max_order');
            $table->integer('min_order');
            $table->integer('shipping_weight');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
