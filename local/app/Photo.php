<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Photo extends Model
{
    use Sluggable;
    
    protected $table = 'photos';

    protected $fillable = ['title','photo_link','content','views','status','featured','category_id','user_id','slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function category(){
    	
    	return $this->belongsTo('App\Category');
    }      
    public function newsletters(){
        
        return $this->hasMany('App\Newsletter');
    }  
     
    public function views(){
        
        return $this->hasMany('App\Views');
    }   

    public function user(){
    	
    	return $this->belongsTo('App\User');
    } 
    public function images(){
        
        return $this->hasMany('App\Image');
    }  
    public function comments(){
    	
    	return $this->hasMany('App\Comment');
    }  
    public function tags(){
    	
    	return $this->belongsToMany('App\Tag')->withTimestamps();
    }     
    public function favorites(){
    	
    	return $this->hasMany('App\Favorite');
    } 
    public function scopeSearch($query, $title){
        $thequery=$query->where('title','like','%'.$title.'%');
        $thequery2= $query->where('title','!=',' ');
        if(count($thequery) > 0){
            return $thequery;
        }else{
            return $thequery2;
        }
    }
}
