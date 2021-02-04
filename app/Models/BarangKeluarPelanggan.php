<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarPelanggan extends Model
{
    protected $table = 'barang_keluar_pelanggans';
    protected $guarded = [];

    public function barangWarung()
    {
        return $this->belongsTo('App\Models\BarangWarung', 'barang_warung_kode', 'kode');
    }
    public function pemesanan()
    {
        return $this->belongsTo('App\Models\PemesananPembeli', 'pemesanan_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function rekapitulasi()
    {
        return $this->hasMany('App\Models\RekapitulasiPenjualanPelanggan');
    }
}
