<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bulky extends Model
{
    protected $table = 'bulkies';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
