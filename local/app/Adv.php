<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    
    protected $table = "advs";

    protected $fillable = ['image','position','section'];

    public function admagesv(){
        return $this->hasMany('App\Image');
    }
}
