<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id', 'f_id',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id','f_id');
    }
}
