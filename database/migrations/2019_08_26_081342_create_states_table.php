<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('state_id');
            $table->string('name')-> unique();
            $table -> integer('countery_id')->unsigned();

            $table->foreign('countery_id')
                  ->references('countery_id')->on('counteries')
                  ->onUpdate('cascade')
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
        Schema::dropIfExists('states');
    }
}
