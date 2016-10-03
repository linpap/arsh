<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   
    protected $table = "notifications";

    protected $fillable = ['description','type','user_id','post_id','ebook_id','photo_id'];

    public function user(){
    	$this->belongsTo('App\User');
    }

    public function post(){
    	$this->belongsTo('App\Post');
    }
    public function photo(){
    	$this->belongsTo('App\Photo');
    }
    public function video(){
    	$this->belongsTo('App\Video');
    }
    public function ebook(){
    	$this->belongsTo('App\Ebook');
    }

}
