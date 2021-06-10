<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tweet extends Model
{
    protected $primaryKey = 'id';
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
