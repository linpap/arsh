<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = ['name','type'];

    public function posts(){
    	return $this->hasMany('App\Post');
    }
    public function navbars(){
    	return $this->hasMany('App\Navbar');
    }
    public function footers(){
        return $this->hasMany('App\Footer');
    }
    public function sidebars(){
        return $this->hasMany('App\Sidebar');
    }
    public function subcategories(){
    	return $this->hasMany('App\Subcategory');
    }
}
