<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'storage_bulkies';
    protected $guarded = [];

    /**
     * Storage belongs to StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageMasukBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = storageIn_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\StorageMasukBulky', 'storage_masuk_bulky_kode', 'kode');
    }

    /**
     * Storage belongs to Tingkat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tingkat()
    {
    	// belongsTo(RelatedModel, foreignKey = tingkat_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\TingkatRakBulky');
    }
}
