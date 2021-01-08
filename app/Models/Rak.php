<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'raks';
    protected $guarded = [];

    /**
     * Rak belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Gudang');
    }

    /**
     * Rak has many Tingkat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tingkat()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = rak_id, localKey = id)
    	return $this->hasMany('App\Models\TIngkatanRak');
    }
}
