<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('total');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('photo_id')->unsigned()->nullable();
            $table->integer('ebook_id')->unsigned()->nullable();
            $table->integer('video_id')->unsigned()->nullable();
            
            $table->foreign('user_id')->references('id')->on('users');  
            $table->foreign('post_id')->references('id')->on('posts');  
            $table->foreign('photo_id')->references('id')->on('photos');  
            $table->foreign('video_id')->references('id')->on('videos');            
            $table->foreign('ebook_id')->references('id')->on('ebooks');
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
        Schema::drop('points');
    }
}
