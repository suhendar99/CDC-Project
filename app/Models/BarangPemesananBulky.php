<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangPemesananBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barang_pemesanan_bulkies';
    protected $guarded = [];

    /**
     * BarangPemesananBulky belongs to PemesananBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesananBulky_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\PemesananBulky', 'pemesanan_bulky_id');
    }
}