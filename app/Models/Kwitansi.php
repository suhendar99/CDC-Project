<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kwitansis';
    protected $guarded = [];

    /**
     * Kwitansi belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesanan()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Pemesanan');
    }

    /**
     * Kwitansi belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Gudang');
    }

    /**
     * Kwitansi has many Retur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function retur()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = kwitansi_id, localKey = id)
        return $this->hasMany('App\Models\Retur');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
