<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_sales', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('product_id')->index('idx_specials_products_id');
            $table->decimal('special_price', 15);
            $table->string('expire_date', 255);
            $table->integer('is_active')->default(1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_sales');
    }
}
