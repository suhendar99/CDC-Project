<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPenjualanPelanggan extends Model
{
    protected $table = 'rekapitulasi_penjualan_pelanggans';
    protected $guarded = []; 

    public function barangKeluarPelanggan()
    {
        return $this->belongsTo('App\Models\BarangKeluarPelanggan','barang_keluar_id','id');
    }
}
