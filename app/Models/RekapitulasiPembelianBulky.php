<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiPembelianBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rekapitulasi_pembelian_bulkies';
    protected $guarded = [];

    /**
     * RekapitulasiPembelianBulky belongs to StorageMasukBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageMasukBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = storageMasukBulky_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\StorageMasukBulky', 'storage_masuk_bulky_id');
    }
}
