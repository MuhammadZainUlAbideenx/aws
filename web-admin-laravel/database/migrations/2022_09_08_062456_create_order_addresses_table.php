<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->bigInteger('country_id');
            $table->string('email', 255);
            $table->bigInteger('state_id');
            $table->bigInteger('city_id');
            $table->string('near_by', 255)->nullable();
            $table->string('address', 255);
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->integer('zip_code');
            $table->string('phone', 255);
            $table->string('address_type', 255);
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
        Schema::dropIfExists('order_addresses');
    }
}
