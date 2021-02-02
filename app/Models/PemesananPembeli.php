<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananPembeli extends Model
{
    protected $table = 'pemesanan_pembelis';
    protected $guarded = [];
    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan', 'pelanggan_id', 'id');
    }
    public function pembeli()
    {
        return $this->belongsTo('App\Models\Pembeli', 'pembeli_id', 'id');
    }
    public function pemesananPembeliItem()
    {
        return $this->hasMany('App\Models\PemesananPembeliItem', 'pemesanan_pembeli_id', 'id');
    }
    public function returMasukPelanggan()
    {
        return $this->hasMany('App\Models\ReturMasukPelanggan', 'pemesanan_pembeli_id', 'id');
    }
}
