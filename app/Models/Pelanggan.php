<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
}
