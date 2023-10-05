<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('email', 255)->nullable()->unique('email');
            $table->string('password', 255)->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->longText('name');
            $table->text('profile_image_path')->nullable();
            $table->string('dob', 255)->nullable();
            $table->bigInteger('profile_image_id');
            $table->integer('role_id')->nullable()->default(2);
            $table->text('contact_phone');
            $table->string('slug', 255);
            $table->integer('is_featured');
            $table->tinyInteger('is_active');
            $table->string('google_id', 100)->nullable();
            $table->string('facebook_id', 100)->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
