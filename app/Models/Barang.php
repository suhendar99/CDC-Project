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
    public function pemesananPembeliItem()
    {
        return $this->hasMany('App\Models\PemesananPembeliItem', 'pemesanan_pembeli_id', 'id');
    }

    /**
     * Barang has many ReturKeluarBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returKeluarBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\ReturKeluarBulky', 'barang_kode', 'kode_barang');
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
     * Barang has many StorageKeluarBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageKeluarBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\StorageKeluarBulky', 'barang_kode', 'kode_barang');
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

    public function barangKeluarPemesananBulky()
    {
        return $this->hasMany('App\Models\BarangKeluarPemesananBulky','barang_kode','kode_barang');
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
     * Barang has many BarangPemesananBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangPemesananBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\BarangPemesananBulky', 'barang_kode', 'kode_barang');
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

    /**
     * Barang has many PemesananKeluarBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pemesananKeluarBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = barang_id, localKey = id)
        return $this->hasMany('App\Models\PemesananKeluarBulky', 'barang_kode', 'kode_barang');
    }
    public function storageKeluarPemasok()
    {
        return $this->hasMany('App\Models\StorageKeluarPemasok','barang_id','id');
    }
}
