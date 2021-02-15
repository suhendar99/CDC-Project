<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturKeluarBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'retur_keluar_bulkies';
    protected $guarded = [];

    /**
     * ReturKeluarBulky belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }

    /**
     * Get the user that owns the ReturKeluarBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengurusGudang(): BelongsTo
    {
        return $this->belongsTo(PengurusGudangBulky::class, 'pengurus_gudang_id', 'id');
    }
    /**
     * Get the storageMasuk that owns the ReturKeluarBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageMasuk(): BelongsTo
    {
        return $this->belongsTo(StorageMasukBulky::class, 'storage_masuk_id', 'id');
    }
}
