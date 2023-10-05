<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->longText('description');
            $table->string('name', 255);
            $table->text('image_id')->nullable();
            $table->text('icon_id');
            $table->integer('is_featured')->default(0);
            $table->integer('parent_id')->default(0)->index('idx_categories_parent_id');
            $table->integer('sort_order')->nullable();
            $table->string('slug');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('categories');
    }
}
