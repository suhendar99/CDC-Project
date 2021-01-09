<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TingkatanRak extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tingkatan_raks';
    protected $guarded = [];

    /**
     * TingkatanRak belongs to Rak.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rak()
    {
    	// belongsTo(RelatedModel, foreignKey = rak_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Rak');
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
