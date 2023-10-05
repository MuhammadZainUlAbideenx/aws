<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 255);
            $table->string('original_media_path', 255);
            $table->string('type', 255);
            $table->string('mime_type', 255);
            $table->string('user_type', 20)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
