<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['test_id'];
    public function test()
    {
    return $this->belongsTo(Test::class);
    }
}
