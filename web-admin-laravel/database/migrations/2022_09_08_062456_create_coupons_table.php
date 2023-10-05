<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code');
            $table->text('description')->nullable();
            $table->boolean('discount_type')->default(false)->comment('Options: fixed_cart, percent, fixed_product and percent_product. Default: fixed_cart.');
            $table->float('amount', 10, 0);
            $table->string('expiry_date');
            $table->integer('usage_count')->nullable();
            $table->string('individual_use', 255)->nullable();
            $table->tinyInteger('exclude_products')->nullable()->default(0);
            $table->integer('usage_limit')->nullable();
            $table->integer('user_limit')->nullable();
            $table->integer('limit_usage_to_x_items')->nullable();
            $table->boolean('free_shipping')->default(false);
            $table->tinyInteger('exclude_categories')->nullable()->default(0);
            $table->integer('vendor_id')->nullable();
            $table->boolean('exclude_sale_items')->nullable();
            $table->decimal('minimum_spend', 10);
            $table->decimal('maximum_spend', 10);
            $table->string('used_by')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_featured')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
