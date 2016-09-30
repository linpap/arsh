<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{    
    protected $table = 'footers';

    protected $fillable = ['position','category_id','status'];

    public function category(){
    	return $this->belongsTo('App\Category');
    }
}
