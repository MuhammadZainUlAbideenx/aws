<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_shipping', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('vendor_id');
            $table->tinyInteger('commission_type')->comment('0 for percentage, 1 for fixed');
            $table->float('commission_rate', 10, 0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rider_shipping');
    }
}
