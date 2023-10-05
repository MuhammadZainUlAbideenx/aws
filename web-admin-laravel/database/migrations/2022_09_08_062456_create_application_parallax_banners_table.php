<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationParallaxBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_parallax_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->text('image');
            $table->string('name', 255);
            $table->string('description', 255);
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
        Schema::dropIfExists('application_parallax_banners');
    }
}
