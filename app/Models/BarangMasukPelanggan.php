<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasukPelanggan extends Model
{
    protected $table = 'barang_masuk_pelanggans';
    protected $guarded = [];

    public function storageOut()
    {
        return $this->belongsTo('App\Models\StorageOut', 'storage_out_kode', 'kode');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function rekapitulasi()
    {
        return $this->hasMany('App\Models\rekapitulasiPembelianPelanggan', 'barang_masuk_id', 'id');
    }
}
