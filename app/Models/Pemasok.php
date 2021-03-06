<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasoks';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function barang()
    {
        return $this->hasMany('App\Models\Barang','pemasok_id');
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
    public function kategori()
    {
        return $this->hasMany('App\Models\Kategori');
    }
    public function rekeningPemasok()
    {
        return $this->hasMany('App\Models\RekeningPemasok');
    }
    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
