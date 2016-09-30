<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    
    protected $table = 'navbars';

    protected $fillable = ['position','category_id','status'];

    public function category(){
    	return $this->belongsTo('App\Category');
    }
}
