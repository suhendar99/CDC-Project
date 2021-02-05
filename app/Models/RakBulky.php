<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rak_bulkies';
    protected $guarded = [];

    /**
     * RakBulky belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'gudang_bulky_id', 'id');
    }

    /**
     * Rak has many Tingkat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tingkat()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = rak_id, localKey = id)
    	return $this->hasMany('App\Models\TingkatRakBulky', 'rak_bulky_id');
    }
}
