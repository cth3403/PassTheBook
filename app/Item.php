<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User as User;

class Item extends Model
{
    protected $table = 'items';


    protected $fillable = ['price', 'title_id', 'condition', 'comments', 'status','ref', 'disp', 'location', 'collect', 'special'];

    /**
     * The attributes which may be used for sorting dynamically.
     *
     * @var array
     */
    protected $sortable = ['price', 'condition', 'created_at', 'ref', 'location', 'collect'];

    protected $dates = ['collect' , 'deleted_at', 'cleared_at'];

    /**
     * An item is listed by a user
     * @return array of items that match 'listed'
     */
    public function listed(){
        return $this->belongsToMany('App\User')->wherePivot('relationship', 'listed');
    }

     /**
     * An item can be enquired by a user
     * @return array items that match 'enquired'
     */
    public function enquired(){
        return $this->belongsToMany('\App\User')->withTimestamps()->wherePivot('relationship', 'enquired');
    }

    public function getTitle(){
        return $this->belongsTo('App\Title', 'title_id');
    }
}
