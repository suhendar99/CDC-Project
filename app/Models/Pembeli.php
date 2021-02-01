<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $table = 'pembelis';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function pemesananPembeli()
    {
        return $this->hasMany('App\Models\PemesananPembeli', 'pembeli_id', 'id');
    }
}
