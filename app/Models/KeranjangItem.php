<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table = 'keranjang_items';
    protected $guarded = [];

    public function keranjang()
    {
        return $this->belongsTo('App\Models\Keranjang');
    }

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }
}
