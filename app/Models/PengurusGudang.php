<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusGudang extends Model
{
    protected $table = 'pengurus_gudangs';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
}
