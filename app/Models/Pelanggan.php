<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function desa()
    {
        return $this->belongsTo('App\Models\Desa');
    }
    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan');
    }
    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten');
    }
    public function penerimaan()
    {
        return $this->hasMany('App\Models\Penerimaan');
    }

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
}
