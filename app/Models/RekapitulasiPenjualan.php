<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPenjualan extends Model
{
    protected $table = 'rekapitulasi_penjualans';
    protected $guarded = [];

    public function storageOut()
    {
        return $this->belongsTo('App\Models\StorageOut');
    }
}
