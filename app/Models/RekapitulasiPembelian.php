<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPembelian extends Model
{
    protected $table = 'rekapitulasi_pembelians';
    protected $guarded = [];

    public function storageIn()
    {
        return $this->belongsTo('App\Models\StorageIn');
    }
}
