<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KwitansiBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kwitansi_bulkies';
    protected $guarded = [];

    /**
     * Kwitansi belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\PemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * Kwitansi belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
