<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangWarung extends Model
{
    protected $table = 'barang_warungs';
    protected $guarded = [];

    public function storageOut()
    {
        return $this->belongsTo('App\Models\StorageOut', 'storage_out_kode', 'kode');
    }
    public function stok()
    {
        return $this->belongsTo('App\Models\StockBarang', 'stok_id', 'id');
    }
    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan', 'pelanggan_id', 'id');
    }
    public function returMasukPelanggan()
    {
        return $this->hasMany('App\Models\ReturMasukPelanggan', 'barang_warung_kode', 'kode');
    }
    public function barangKeluar()
    {
        return $this->hasMany('App\Models\BarangKeluarPelanggan', 'barang_warung_kode', 'kode');
    }
    public function pemesananPembeliItem()
    {
        return $this->hasMany('App\Models\PemesananPembeliItem','barang_warung_kode','kode');
    }
}
