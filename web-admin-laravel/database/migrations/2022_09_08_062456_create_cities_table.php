<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 255);
            $table->unsignedMediumInteger('state_id')->index('cities_test_ibfk_1');
            $table->unsignedMediumInteger('country_id')->index('cities_test_ibfk_2');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->integer('code')->nullable();
            $table->integer('is_active');
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('created_at')->default('2014-01-01 06:01:01');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->boolean('flag')->default(true);
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
