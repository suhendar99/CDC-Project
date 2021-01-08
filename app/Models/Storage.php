<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'storages';
    protected $guarded = [];

    /**
     * Storage belongs to StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageIn()
    {
    	// belongsTo(RelatedModel, foreignKey = storageIn_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\StorageIn', 'storage_in_kode', 'kode');
    }
}
