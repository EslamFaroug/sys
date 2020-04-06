<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->increments('interest_id');
            
            $table-> integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table-> string('title');
            $table-> text('descrip')->nullable();
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
        Schema::dropIfExists('interests');
    }
}
