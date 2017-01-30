<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsbnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isbns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn');
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->string('type')->default('isbn');
            $table->softDeletes();
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
        Schema::dropIfExists('isbns');
    }
}
