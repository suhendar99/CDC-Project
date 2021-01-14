<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function rekeningPemasok()
    {
        return $this->hasMany('App\Models\RekeningPemasok');
    }
    public function piutang()
    {
        return $this->hasMany('App\Models\Piutang');
    }
}
