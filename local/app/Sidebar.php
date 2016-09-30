<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    
    protected $table = 'sidebars';

    protected $fillable = ['position','category_id','status'];

    public function category(){
    	return $this->belongsTo('App\Category');
    }
}
