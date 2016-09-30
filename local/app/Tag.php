<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";

    protected $fillable = ['name'];

    public function posts(){
        
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
    public function photos(){
        
        return $this->belongsToMany('App\Photo')->withTimestamps();
    }
    public function ebooks(){
        
        return $this->belongsToMany('App\Ebook')->withTimestamps();
    }
    public function videos(){
        
        return $this->belongsToMany('App\Video')->withTimestamps();
    }

    public function scopeSearch($query, $name){
    	$thequery=$query->where('name','like','%'.$name.'%');
    	$thequery2= $query->where('name','!=',' ');
    	if(count($thequery) > 0){
    		return $thequery;
    	}else{
    		return $thequery2;
    	}
    }
}
