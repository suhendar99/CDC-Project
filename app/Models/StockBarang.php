<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBarang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_barangs';
    protected $guarded = [];

    /**
     * StockBarang belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockBarangBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\StockBarangBulky', 'barang_bulky_id');
    }

    /**
     * StockBarang has many Storage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storage()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = stockBarang_id, localKey = id)
        return $this->hasMany('App\Models\Storage', 'barang_retail_id');
    }

    /**
     * StockBarang belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Gudang');
    }

    public function barangWarung()
    {
        return $this->hasMany('App\Models\BarangWarung', 'stok_id', 'id');
    }
}
