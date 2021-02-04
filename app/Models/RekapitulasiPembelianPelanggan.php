<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPembelianPelanggan extends Model
{
    protected $table = 'rekapitulasi_pembelian_pelanggans';
    protected $guarded = [];

    public function barangMasuk()
    {
        return $this->belongsTo('App\Models\BarangMasukPelanggan', 'barang_masuk_id', 'id');
    }
}
