<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id','id');
    }

    public function friends()
    {
        return $this->hasMany('App\Friend', 'u_id', 'id');
    }

    public function friendships1(){
        return $this->hasMany('App\Friendship', 'user_id', 'id');
    }

    public function friendships2(){
        return $this->hasMany('App\Friendship', 'friend_id', 'id');
    }

//    public function getmessages(){
//        return $this->hasMany('App\Massege', 'getter_id', 'id');
//    }
//
//    public function sentmessages(){
//        return $this->hasMany('App\Massege', 'sender_id', 'id');
//    }
}
