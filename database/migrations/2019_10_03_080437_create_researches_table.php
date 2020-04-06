<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->increments('research_id');

            $table-> integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table-> string('title');

            $table-> integer('degree_id')->unsigned();
            $table->foreign('degree_id')
                  ->references('degree_id')->on('degrees')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table -> integer('supervisor_id') -> nullable() -> comment('from teachers table as supervisor');
            $table -> date('publish_date');
            $table -> string('publish_place');
            $table -> string('other_supervisor') -> nullable();
            $table -> string('research_file') -> nullable();

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
        Schema::dropIfExists('researches');
    }
}
