<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('exp_id');
            $table-> integer('teacher_id')->unsigned();

            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table-> integer('degree_id')->nullable()->comment('from degrees table');
            $table-> integer('mangejob_id')->nullable()->comment('from mangejobs_table');
            $table-> string('exp_name')->nullable();
            $table-> string('institute')->nullable();
            $table-> integer('university_id')->nullable();
            $table-> integer('college_id')->nullable();
            $table-> integer('depart_id')->nullable();
            $table-> integer('special_id')->nullable();
            $table-> integer('work_id')->nullable()->comment('work type from: work_types');
            $table-> integer('type_id')->nullable()->comment('work domain from:types');
            $table-> integer('countery_id')->nullable()->comment('work place1');
            $table-> string('work_place_2')->nullable();
            $table-> date('start_date');
            $table-> date('end_date');
            $table-> text('decrip')->nullable();
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
        Schema::dropIfExists('experiences');
    }
}
