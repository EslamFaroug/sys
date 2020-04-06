<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('teacher_id');
            $table -> string('ar_name');
            $table -> string('en_name');
            $table -> string('card_id') ->comment('National Card number');
            $table -> date('dob')   ->comment('Date of Birth');
            $table -> string('pob') ->comment('place of birth');
            $table -> string('gender')->comment('sex type');
            $table -> integer('status')->comment('Social or martial status');
            $table -> string('mother_tounge');

            $table-> integer('countery_id')->unsigned();

            $table->foreign('countery_id')
                  ->references('countery_id')->on('counteries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table -> unsignedInteger('degree_id')->comment('from degrees table');
            $table->foreign('degree_id')
                ->references('degree_id')->on('degrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table -> unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('teachers');
    }
}
