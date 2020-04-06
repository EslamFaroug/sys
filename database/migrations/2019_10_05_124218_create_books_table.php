<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('book_id');

            $table-> integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')
                  ->references('teacher_id')->on('teachers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table-> string('title');
            $table-> string('isbn')->nullable();
            $table-> string('publisher');
            $table-> date('f_edition')->nullable();
            $table-> date('l_edition')->nullable();
            $table-> string('book_file')->nullable();
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
        Schema::dropIfExists('books');
    }
}
