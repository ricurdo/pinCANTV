<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_code');                       //Serial
            $table->integer('retailer_id');
            $table->date('creation_date');
            $table->integer('status')->length(2);
            $table->date('status_date')->nullable();
            $table->integer('access_number')->length(15)->nullable();
            $table->date('used_date')->nullable();
            $table->integer('access_code')->length(16);        //pin secreto
            $table->integer('load_batch');
            $table->string('amount_id');                       //Valor facial
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
