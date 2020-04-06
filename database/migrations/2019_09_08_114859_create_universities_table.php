<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->increments('university_id');
            $table -> string('name')->unique();
            $table -> integer('type_id')->unsigned();
            $table->foreign('type_id')
                ->references('type_id')->on('types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('universities');
    }
}
