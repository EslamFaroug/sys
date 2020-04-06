<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenaralStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genaral__statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('Type')->comment("Universities or Teachers");

            $table -> unsignedInteger('countery_id')->nullable();
            $table->foreign('countery_id')
                ->references('countery_id')->on('counteries')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table -> unsignedInteger('type_id')->nullable();
            $table->foreign('type_id')
                ->references('type_id')->on('types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('university_id')->nullable();
            $table->foreign('university_id')
                ->references('university_id')->on('universities')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('college_id')->nullable();
            $table->foreign('college_id')
                ->references('college_id')->on('colleges')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('depart_id')->nullable();
            $table->foreign('depart_id')
                ->references('depart_id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('special_id')->nullable();
            $table->foreign('special_id')
                ->references('special_id')->on('specials')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table-> unsignedInteger('degree_id')->nullable();
            $table->foreign('degree_id')
                ->references('degree_id')->on('degrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('show');

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
        Schema::dropIfExists('genaral__statistics');
    }
}
