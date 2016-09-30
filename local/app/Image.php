<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['name','post_id','ebook_id','video_id','photo_id','adv_id'];

    public function post(){
        
        return $this->belongsTo('App\Post');
    }
    public function photo(){
        
        return $this->belongsTo('App\Photo');
    } 
    public function ebook(){
        
        return $this->belongsTo('App\Ebook');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function adv(){
        return $this->belongsTo('App\Adv');
    }
}
