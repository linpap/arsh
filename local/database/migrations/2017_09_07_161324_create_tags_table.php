<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('post_tag',function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ebook_tag',function(Blueprint $table){
            $table->increments('id');
            $table->integer('ebook_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('photo_tag',function(Blueprint $table){
            $table->increments('id');
            $table->integer('photo_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tag_video',function(Blueprint $table){
            $table->increments('id');
            $table->integer('video_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::drop('post_tag');
        Schema::drop('tag_video');
        Schema::drop('photo_tag');
        Schema::drop('ebook_tag');
        Schema::drop('tags');
    }
}
