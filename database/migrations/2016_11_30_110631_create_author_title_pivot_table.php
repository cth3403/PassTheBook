<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTitlePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_title', function (Blueprint $table) {
            $table->integer('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->primary(['author_id', 'title_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('author_title');
    }
}
