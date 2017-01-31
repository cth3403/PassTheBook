<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    protected $table = 'creators';

    public function titles(){
   		return $this->belongsToMany('App\Title')->withTimestamps();
   	}
}
