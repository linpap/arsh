<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = "reviews";

    protected $fillable = ['content','video_id','photo_id','ebook_id','post_id','user_id'];

    public function post(){
    	return $this->belongsTo('App/Post');
    }
    public function videopost(){
    	return $this->belongsTo('App/Video');
    }
    public function ebook(){
    	return $this->belongsTo('App/Ebook');
    }
    public function phostpost(){
    	return $this->belongsTo('App/Photo');
    }
}
