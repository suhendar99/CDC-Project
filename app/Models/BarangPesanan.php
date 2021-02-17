<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangPesanan extends Model
{
    protected $table = 'barang_pesanans';
    protected $guarded = [];

    /**
     * BarangPesanan belongs to StockBarangRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockBarangRetail()
    {
        // belongsTo(RelatedModel, foreignKey = stockBarangRetail_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\StockBarang', 'barang_retail_id');
    }

    public function pesanan()
    {
        return $this->belongsTo('App\Models\Pemesanan', 'pemesanan_id', 'id');
    }
}
