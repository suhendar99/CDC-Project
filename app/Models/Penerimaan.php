<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $table = 'penerimaans';
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
}
