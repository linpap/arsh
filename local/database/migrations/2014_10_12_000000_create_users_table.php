<?php

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
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('facebook_id');
            $table->string('profile_image');
            $table->string('tagline');
            $table->string('twitter_id');
            $table->string('twitter_real');
            $table->string('facebook_real');
            $table->integer('points');
            $table->boolean('activated')->default(false);
            $table->string('bkash');
            $table->string('password');
            $table->string('featured');
            $table->enum('type',['admin','editor','writer','subscriber'])->default('writer');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}