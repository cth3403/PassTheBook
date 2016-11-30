<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lname');
            $table->string('fname');
            $table->string('uni_id',15)->nullable();
            $table->string('email')->unique();
            $table->string('pay')->nullable();
            $table->string('password', 60);
            $table->boolean('admin')->default(false);
            $table->boolean('valid')->default(false);
            $table->integer('free')->default(0);
            $table->string('type')->default('user');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
