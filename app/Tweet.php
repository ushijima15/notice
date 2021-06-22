<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tweet extends Model
{
    protected $primaryKey = 'id';
    public function tests()
    {
        return $this->hasMany('App\Test');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function like()
    {
        return $this->hasMany('App\Like');
    }
    public function notice()
    {
        return $this->hasMany('App\Notice');
    }
    // public function is_liked_by_auth_user()
    // {
    //   $id = Auth::id();
  
    //   $likers = array();
    //   foreach($this->likes as $like) {
    //     array_push($likers, $like->user_id);
    //   }
    //   if (in_array($id, $likers)) {
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }
}
