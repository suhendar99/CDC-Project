<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';
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
