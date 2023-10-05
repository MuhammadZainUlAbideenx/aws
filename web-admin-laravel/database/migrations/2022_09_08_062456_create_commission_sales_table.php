<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_sale');
            $table->integer('to_sale');
            $table->float('rate', 10, 0);
            $table->integer('rate_type')->nullable();
            $table->string('duration', 255);
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
        Schema::dropIfExists('commission_sales');
    }
}
