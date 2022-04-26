<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDonation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_donation', function (Blueprint $table) {
            $table->increments('id_trx_donation');
            $table->integer('id_donation');
            $table->integer('id_transfer_method');
            $table->integer('status');
            $table->bigInteger('nominal');
            $table->timestamps();
            $table->timestamp('trx_expired');

            $table->foreign('id_donation')->references('id_donation')->on('donation');
            $table->foreign('id_transfer_method')->references('id_transfer_method')->on('transfer_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_donation');
    }
}
