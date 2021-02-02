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

    /**
     * Barang has many StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageIn()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StorageIn', 'barang_kode', 'kode_barang');
    }

    /**
     * Barang has many StorageMasukBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageMasukBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StorageMasukBulky', 'barang_kode', 'kode_barang');
    }

    /**
     * Barang has many Stock.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StockBarang', 'barang_kode', 'kode_barang');
    }

    /**
     * Barang has many StockBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StockBarangBulky', 'barang_kode', 'kode_barang');
    }

    /**
     * Barang has many StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageOut()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StorageOut', 'barang_kode', 'kode_barang');
    }
    public function penerimaan()
    {
        return $this->hasMany('App\Models\Penerimaan');
    }
    public function province()
    {
        return $this->belongsTo('App\Province','province_id','id');
    }
    public function city()
    {
        return $this->belongsTo('App\City','city_id','id');
    }

    public function foto()
    {
        return $this->hasMany('App\Models\FotoBarang');
    }
    /**
     * Barang has many Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangPesanan()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\BarangPesanan', 'barang_kode', 'kode_barang');
    }

    /**
     * Barang belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function retur()
    {
        // belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\Retur', 'barang_retur_masuks', 'barang_id', 'retur_id');
    }

    public function returOut()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\ReturOut', 'barang_kode', 'kode_barang');
    }
}
