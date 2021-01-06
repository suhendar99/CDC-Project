<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsis';
    protected $guarded = [];

    public function pemasok()
    {
        return $this->hasMany('App\Models\Pemasok');
    }
    public function pelanggan()
    {
        return $this->hasMany('App\Models\Pelanggan');
    }
}
