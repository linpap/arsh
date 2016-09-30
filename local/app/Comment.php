<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['comment','post_id','user_id','email','name','web'];


    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function post(){
    	return $this->belongsTo('App\Post');
    }
    public function photo(){
    	return $this->belongsTo('App\Photo');
    }
    public function video(){
    	return $this->belongsTo('App\Video');
    }
    public function ebook(){
    	return $this->belongsTo('App\Ebook');
    }
}
