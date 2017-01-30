<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->string('condition');
            $table->decimal('price',6,2);
            $table->text('comments');
            $table->string('status')->default('review');;
            $table->string('disp')->default('hide');;
            $table->string('type')->default('item');
            $table->string('location')->nullable();
            $table->string('collect')->nullable()->default(null);
            $table->string('ref');
            $table->integer('special')->default(0);
            $table->date('cleared_at')->nullable()->default(null);
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
        Schema::dropIfExists('items');
    }
}
