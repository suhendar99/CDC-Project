<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarPemesananBulky extends Model
{
    protected $table = 'barang_keluar_pemesanan_bulkies';
    protected $guarded = [];

    public function pemesanan()
    {
        return $this->belongsTo('App\Models\PemesananKeluarBulky','pemesanan_id','id');
    }
    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }
}
