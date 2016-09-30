<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contributions extends Model
{
    protected $table = "contributions";

    protected $fillable = ['name'];

    public function posts(){
    	
    	return $this->hasMany('App\Post');
    }
}
