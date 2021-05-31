<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    /**
     * ユーザを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
