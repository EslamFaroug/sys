<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('contact_id');
            $table-> integer('teacher_id')->unsigned();

            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table-> string('email') -> unique();
            $table-> integer('mobile_no') -> nullable();
            $table-> integer('tel_no') -> nullable();
            $table-> integer('home_no') -> nullable();
            $table-> string('tr_web') -> nullable();
            $table-> integer('university_id') -> nullable();
            $table-> integer('college_id') -> nullable();
            $table-> integer('depart_id') -> nullable();
            $table-> integer('special_id')->nullable();
            $table-> integer('countery_id') -> nullable();
            $table-> integer('state_id') -> nullable();
            $table-> integer('regional_id') -> nullable();
            $table-> integer('unit_id') -> nullable();

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
        Schema::dropIfExists('contacts');
    }
}
