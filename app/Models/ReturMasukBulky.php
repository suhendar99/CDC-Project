<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturMasukBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'retur_masuk_bulkies';
    protected $guarded = [];

    /**
     * ReturMasukBulky belongs to PemesananBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky()
    {
        // belongsTo(RelatedModel, foreignKey = pemesananBulky_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\PemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * ReturMasukBulky belongs to BarangBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barangBulky()
    {
        // belongsTo(RelatedModel, foreignKey = barangBulky_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\StockBarangBulky', 'barang_bulky_id');
    }

    /**
     * ReturMasukBulky belongs to Satuan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function satuan()
    {
        // belongsTo(RelatedModel, foreignKey = satuan_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\Satuan', 'satuan_id');
    }
}
