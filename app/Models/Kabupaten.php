<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupatens';
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
