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
     * ReturMasukBulky belongs to KwitansiBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kwitansiBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = kwitansiBulky_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\KwitansiBulky', 'kwitansi_bulky_id');
    }
}
