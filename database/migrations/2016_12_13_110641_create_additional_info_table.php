<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_info', function (Blueprint $table) {
            $table->increments('id');
            // edition info for books
            $table->string('field1')->nullable();
            // volume info for books
            $table->string('field2')->nullable();
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
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
        Schema::dropIfExists('additional_info');
    }
}
