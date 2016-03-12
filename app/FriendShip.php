<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendShip extends Model
{
    //
    protected $fillable = ['user1_id', 'user2_id'];

    public function Users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
