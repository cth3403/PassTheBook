<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsbnTitlePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isbn_title', function (Blueprint $table) {
            $table->integer('isbn_id')->unsigned()->index();
            $table->foreign('isbn_id')->references('id')->on('isbns')->onDelete('cascade');
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->primary(['isbn_id', 'title_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('isbn_title');
    }
}
