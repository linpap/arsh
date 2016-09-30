<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type','facebook_id','bkash','twitter_id','real_id','featured','profile_image','activated','tagline','facebook_real','twitter_real'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts(){
        
        return $this->hasMany('App\Post');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function photos(){
        
        return $this->hasMany('App\Photo');
    }
    public function videos(){
        
        return $this->hasMany('App\Video');
    }

    public function images(){
        
        return $this->hasMany('App\Image');
    }
}
