<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surat_jalan_bulkies';
    protected $guarded = [];

    /**
     * SuratJalan belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\PemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * Surat Jalan belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\User');
    }
}
