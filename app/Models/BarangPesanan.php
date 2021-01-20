<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangPesanan extends Model
{
    protected $table = 'barang_pesanans';
    protected $guarded = [];

    public function barang()
    {
        $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }
 
    public function pesanan()
    {
        $this->belongsTo('App\Models\Pemesanan', 'pemesanan_id');
    }
}
