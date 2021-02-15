<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageKeluarPemasok extends Model
{
    protected $table = 'storage_keluar_pemasoks';
    protected $guarded = [];

    public function pemesananKeluarBulky()
    {
        return $this->belongsTo('App\Models\PemesananKeluarBulky', 'pemesanan_keluar_bulky_id', 'id');
    }
    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function satuan()
    {
        return $this->belongsTo('App\Models\Satuan');
    }
    public function kwitansiPemasok()
    {
        return $this->hasOne('App\Models\KwitansiPemasok');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
