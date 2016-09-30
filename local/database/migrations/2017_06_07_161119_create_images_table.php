_<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(null);
            $table->integer('post_id')->unsigned()->nullable()->default(null);
            $table->integer('photo_id')->unsigned()->nullable()->default(null);
            $table->integer('video_id')->unsigned()->nullable()->default(null);
            $table->integer('ebook_id')->unsigned()->nullable()->default(null);
            $table->integer('adv_id')->unsigned()->nullable()->default(null);

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
            $table->foreign('adv_id')->references('id')->on('advs')->onDelete('cascade');
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
        Schema::drop('images');
    }
}
