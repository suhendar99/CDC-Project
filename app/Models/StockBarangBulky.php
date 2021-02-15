<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBarangBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_barang_bulkies';
    protected $guarded = [];

    /**
     * StockBarang belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }

    /**
     * StockBarang belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }

    /**
     * StockBarangBulky has many StorageMasukRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageMasukRetail()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = stockBarangBulky_id, localKey = id)
        return $this->hasMany('App\Models\StorageIn', 'barang_bulky_id');
    }

    /**
     * StockBarangBulky has many BarangPemesananBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangPemesananBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = stockBarangBulky_id, localKey = id)
        return $this->hasMany('App\Models\BarangPemesananBulky', 'barang_bulky_id');
    }

    /**
     * StockBarangBulky has many StockBarangRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockBarangRetail()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = stockBarangBulky_id, localKey = id)
        return $this->hasMany('App\Models\StockBarang', 'barang_bulky_id');
    }

    /**
     * StockBarangBulky has many StorageKeluarBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageKeluarBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = stockBarangBulky_id, localKey = id)
        return $this->hasMany('App\Models\StorageKeluarBulky', 'barang_bulky_id');
    }
}
