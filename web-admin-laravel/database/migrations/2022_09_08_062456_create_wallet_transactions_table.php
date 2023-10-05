<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wallet_id');
            $table->string('order_number')->nullable();
            $table->string('transaction_id', 100);
            $table->string('transaction_type');
            $table->float('cash_in', 10, 0)->nullable();
            $table->float('cash_out', 10, 0)->nullable();
            $table->float('opening_balance', 10, 0)->nullable();
            $table->float('closing_balance', 10, 0)->nullable();
            $table->string('description');
            $table->timestamps();

            $table->unique(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
