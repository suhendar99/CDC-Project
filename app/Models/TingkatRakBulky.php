<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TingkatRakBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tingkat_rak_bulkies';
    protected $guarded = [];

    /**
     * TingkatanRak belongs to Rak.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rak()
    {
    	// belongsTo(RelatedModel, foreignKey = rak_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\RakBulky', 'rak_bulky_id');
    }

    /**
     * TingkatanRak has many Storage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storage()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = tingkatanRak_id, localKey = id)
    	return $this->hasMany('App\Models\Storage', 'tingkat_id');
    }
}
