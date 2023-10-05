<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_stores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('vendor_id', 255)->nullable()->unique('email');
            $table->string('cover_image_id', 255)->nullable();
            $table->bigInteger('logo_image_id')->nullable();
            $table->longText('description');
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('city_id', 255);
            $table->bigInteger('country_id');
            $table->bigInteger('state_id');
            $table->string('phone', 255);
            $table->string('postal_code', 255);
            $table->string('slug', 255);
            $table->string('headline', 255);
            $table->tinyInteger('is_active');
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
        Schema::dropIfExists('vendor_stores');
    }
}
