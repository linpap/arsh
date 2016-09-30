<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('position');
            $table->string('script');
            $table->enum('section',['post_single','ebook_single','photo_single','video_single','video','photo','ebook','home','archive','profile','category']);
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
        Schema::drop('advs');
    }
}
