<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsbnRlistPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isbn_rlist', function (Blueprint $table) {
            $table->integer('isbn_id')->unsigned()->index();
            $table->foreign('isbn_id')->references('id')->on('isbns')->onDelete('cascade');
            $table->integer('rlist_id')->unsigned()->index();
            $table->foreign('rlist_id')->references('id')->on('rlists')->onDelete('cascade');
            $table->primary(['isbn_id', 'rlist_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('isbn_rlist');
    }
}
