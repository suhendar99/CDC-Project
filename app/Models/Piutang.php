<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table = 'piutangs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getData()
    {
        return static::with('user','bank')->orderBy('id','desc')->get();
    }
    public function pemesanan()
    {
        return $this->belongsTo('App\Models\Pemesanan','barang_id','id');
    }
}
