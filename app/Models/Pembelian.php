<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang',);
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan');
    }
    public function getData()
    {
        return static::with('barang','pelanggan','pemasok')->orderBy('id','desc')->get();
    }
    public function province()
    {
        return $this->belongsTo('App\Province','province_id','id');
    }
    public function city()
    {
        return $this->belongsTo('App\City','city_id','id');
    }
}
