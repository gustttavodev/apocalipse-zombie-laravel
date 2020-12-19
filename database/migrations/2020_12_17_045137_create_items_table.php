<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item');
            $table->integer('water')->unsigned();
            $table->integer('food')->unsigned();
            $table->integer('medicament')->unsigned();
            $table->integer('ammunition')->unsigned();
            $table->integer('survivor_id')->unsigned();
            $table->foreign('survivor_id')
                ->references('id')
                ->on('survivor')
                ->onDelete('cascade');

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
        Schema::dropIfExists('items');
    }
}
