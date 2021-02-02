<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturMasukPelanggan extends Model
{
    protected $table = 'retur_masuk_pelanggans';
    protected $guarded = [];

    public function kode()
    {
        return $this->belongsTo('App\Models\BarangWarung', 'barang_warung_kode', 'kode');
    }
    public function pemesanan()
    {
        return $this->belongsTo('App\Models\PemesananPembeli', 'pemesanan_pembeli_id', 'id');
    }
}
