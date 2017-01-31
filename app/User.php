<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Vinkla\Hashids\Facades\Hashids;
use Gbrock\Table\Traits\Sortable;

use App\Item as Item;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Table name
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fname', 'lname','uni_id', 'email', 'password', 'pay'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'uni_id', 'administrator', 'valid'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
     * The attributes which may be used for sorting dynamically.
     *
     * @var array
     */
    protected $sortable = ['lname', 'fname', 'email', 'created_at'];

    /**
     * get the value of the Admin column which is then cast as TRUE or FALSE
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getAdminAttribute($value){
        return (bool) $value;
    }

    /**
     * An item is listed by a user
     * @return array of items that match 'listed'
     */
    public function listed(){
        return $this->belongsToMany('\App\Item')->wherePivot('relationship', 'listed');
    }

    /**
     * An item can be enquired by a user
     * @return array items that match 'enquired'
     */
    public function enquired(){
        return $this->belongsToMany('\App\Item')->withTimestamps()->wherePivot('relationship', 'enquired');
    }
}
