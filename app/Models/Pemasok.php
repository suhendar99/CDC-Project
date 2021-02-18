<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function storageKeluarPemasok()
    {
        return $this->hasMany('App\Models\StorageKeluarPemasok');
    }
    public function kwitansiPemasok()
    {
        return $this->hasMany('App\Models\KwitansiPemasok');
    }
    /**
     * Get all of the labaRugiPemasok for the Pemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labaRugiPemasok(): HasMany
    {
        return $this->hasMany(LabaRugiPemasok::class, 'pemasok_id', 'id');
    }
}
