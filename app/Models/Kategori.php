<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $guarded = [];

    public function barang()
    {
        return $this->hasMany('App\Models\Barang');
    }

    public function getAll()
    {
    	return static::orderBy('nama')->get();
    }
}
