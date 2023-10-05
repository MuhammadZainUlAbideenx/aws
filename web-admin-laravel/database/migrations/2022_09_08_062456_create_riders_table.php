<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('email', 255)->nullable()->unique('email');
            $table->string('password', 255)->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->longText('first_name');
            $table->longText('last_name');
            $table->string('profile_image_path', 255)->nullable();
            $table->string('dob', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('gender')->nullable();
            $table->bigInteger('profile_image_id');
            $table->integer('role_id')->nullable()->default(2);
            $table->integer('vendor_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->bigInteger('country_id');
            $table->bigInteger('state_id');
            $table->bigInteger('city_id');
            $table->bigInteger('zip_code');
            $table->text('phone');
            $table->tinyInteger('is_active');
            $table->string('store_type');
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
        Schema::dropIfExists('riders');
    }
}
