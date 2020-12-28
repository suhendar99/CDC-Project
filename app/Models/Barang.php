<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function getData()
    {
        return static::with('kategori','pemasok')->orderBy('id','desc')->get();
    }
    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
