<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang',);
    }
    public function pembelian()
    {
        return $this->belongsTo('App\Models\Pembelian',);
    }
}
