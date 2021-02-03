<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananPembeliItem extends Model
{
    protected $table = 'pemesanan_pembeli_items';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }

    public function barangWarung()
    {
        return $this->belongsTo('App\Models\BarangWarung','barang_warung_kode','kode');
    }

    public function pemesananPembeli()
    {
        return $this->belongsTo('App\Models\PemesananPembeli', 'pemesanan_pembeli_id', 'id');
    }
}
