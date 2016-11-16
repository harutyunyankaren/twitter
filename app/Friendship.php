<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    public function friend(){
        return $this->belongsTo('App\User', 'friend_id', 'id');
    }
    public function friend2(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
