<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table)
        {
           $table->increments('train_id');
           $table-> integer('teacher_id')->unsigned();

            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table-> string('title');
            $table-> string('institute');
            $table-> integer('countery_id')->comment('training place');
            $table-> integer('special_id')->comment('track of training');
            $table-> date('st_date');
            $table-> date('end_date');
            $table-> string('path');
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
        Schema::dropIfExists('trains');
    }
}
