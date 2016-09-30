<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    
    protected $table = "views";

    protected $fillable = ['ip','post_id','video_id','photo_id','ebook_id'];

    public function post(){
    	return $this->belongsTo('App\Post');
    }
    public function video(){
    	return $this->belongsTo('App\Video');
    }
    public function ebook(){
    	return $this->belongsTo('App\Ebook');
    }
    public function photo(){
    	return $this->belongsTo('App\Photo');
    }
}
