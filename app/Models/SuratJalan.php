<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surat_jalans';
    protected $guarded = [];

    /**
     * SuratJalan belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesanan()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Pemesanan');
    }
}
