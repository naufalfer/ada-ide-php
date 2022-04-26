<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation', function (Blueprint $table) {
            $table->increments('id_donation');
            $table->integer('id_project');
            $table->integer('id_user');
            $table->timestamp('created_at')->useCurrent();
            $table->bigInteger('nomimal');
            $table->string('name', 32);
            $table->string('nowhatsapp', 13);
            $table->string('description', 255);
            $table->string('photo');
            $table->boolean('is_anonim');

            $table->foreign('id_project')->references('id_project')->on('project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donation');
    }
}
