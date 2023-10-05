<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('description', 255);
            $table->text('image');
            $table->integer('discount')->nullable();
            $table->text('heading')->nullable();
            $table->text('button_text')->nullable();
            $table->integer('slider_type');
            $table->integer('url_type')->default(1)->comment('1:internal 2:external');
            $table->text('website_url');
            $table->string('expiry_date', 255)->nullable();
            $table->integer('is_active');
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
        Schema::dropIfExists('slider_images');
    }
}
