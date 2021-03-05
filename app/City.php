<?php

namespace App;

use App\Models\Gudang;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    /**
     * Get all of the comments for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelanggan(): HasMany
    {
        return $this->hasMany(Pelanggan::class, 'kota_asal', 'city_id');
    }
    public function gudang(): HasMany
    {
        return $this->hasMany(Gudang::class, 'kota_asal', 'city_id');
    }
}
