<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('paper_id');
            $table-> integer('teacher_id')->unsigned();

            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table-> string('title');
            $table-> string('publish_place');
            $table-> date('publis_date');
            $table-> string('volume_no');
            $table-> string('peper_file')->nullable();
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
        Schema::dropIfExists('papers');
    }
}
