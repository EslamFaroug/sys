<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('cert_id');
            $table-> integer('teacher_id')->unsigned();

            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table-> unsignedInteger('degree_id');
            $table->foreign('degree_id')
                ->references('degree_id')->on('degrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> string('cert_name');

            $table-> unsignedInteger('university_id');
            $table->foreign('university_id')
                ->references('university_id')->on('universities')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('college_id');
            $table->foreign('college_id')
                ->references('college_id')->on('colleges')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('depart_id');
            $table->foreign('depart_id')
                ->references('depart_id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('special_id');
            $table->foreign('special_id')
                ->references('special_id')->on('specials')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('countery_id');
            $table->foreign('countery_id')
                ->references('countery_id')->on('counteries')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('study_id');
            $table->foreign('study_id')
                ->references('study_id')->on('study_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> date('cert_date');
            $table-> string('sert_grade');
            $table-> string('cert_image')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
