<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('video_id')->unsigned()->nullable();
            $table->integer('ebook_id')->unsigned()->nullable();
            $table->integer('photo_id')->unsigned()->nullable();


            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('ebook_id')->references('id')->on('ebooks');
            $table->foreign('video_id')->references('id')->on('videos');
            $table->foreign('photo_id')->references('id')->on('photos');
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
        Schema::drop('views');
    }
}
