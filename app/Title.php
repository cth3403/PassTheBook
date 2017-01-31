<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gbrock\Table\Traits\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Conner\Tagging\Taggable;

class Title extends Model
{

	use SoftDeletes, Sortable, Taggable;

	/**
     * Table name
     * @var string
     */
    protected $table = 'titles';


    /** 
   	* fillable fields that can be mass assigned when using Eloquent
   	* @var 
   	*/
	protected $fillable = [
			'title', 'subtitle', 'pubdate'
	];


    public function getIsbn(){
		return $this->hasMany('App\Isbn');
	}

    public function getItem(){
		return $this->hasMany('App\Item');
	}

	public function creators(){
   		return $this->belongsToMany('App\Creator')->withTimestamps();
   	}




}
