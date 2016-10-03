<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('photo_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->integer('ebook_id')->unsigned();
            $table->integer('video_id')->unsigned();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); 
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');  
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');            
            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
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
        Schema::drop('notifications');
    }
}
