<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    protected $table = 'kwitansis';
    protected $guarded = [];

    public function pemesanan()
    {
        return $this->belongsTo('App\Models\Pemesanan');
    }
    public function gudang()
    {
        return $this->belongsTo('App\Models\Gudang');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
