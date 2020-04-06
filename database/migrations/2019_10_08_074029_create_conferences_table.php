<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->increments('conf_id');

            $table-> integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table-> string('name');
            $table -> integer('countery_id')->unsigned();
            $table->foreign('countery_id')
                  ->references('countery_id')->on('counteries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table -> integer('state_id')->unsigned();
            $table->foreign('state_id')
                    ->references('state_id')->on('states')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table-> date('conf_date');
            $table-> string('participant');
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
        Schema::dropIfExists('conferences');
    }
}
