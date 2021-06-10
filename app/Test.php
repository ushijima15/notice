<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Test extends Model
{
    protected $primaryKey = 'id';
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
