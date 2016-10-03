<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rightblock extends Model
{
    
    protected $table = 'rightblocks';

    protected $fillable = ['title','description','type'];
}
