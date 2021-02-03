<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPenjualanBulky extends Model
{
    protected $table = 'rekapitulasi_penjualan_bulkies';
    protected $guarded = [];

    public function storageKeluarBulky()
    {
        return $this->belongsTo('App\Models\StorageKeluarBulky', 'storage_keluar_bulky_id');
    }
}
