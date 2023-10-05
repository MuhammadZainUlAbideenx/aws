<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 255)->nullable()->unique('email');
            $table->string('password', 255)->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->bigInteger('role_id');
            $table->bigInteger('country_id');
            $table->bigInteger('state_id');
            $table->bigInteger('city_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('gender', 255);
            $table->string('dob', 255);
            $table->text('profile_image_path')->nullable();
            $table->string('phone', 255);
            $table->string('address', 255);
            $table->bigInteger('zip_code');
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
        Schema::dropIfExists('admins');
    }
}
