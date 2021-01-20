<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $guarded = [];

    /**
     * Pemesanan belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barangPesanan()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->hasMany('App\Models\BarangPesanan', 'pemesanan_id', 'id');
    }


    /**
     * Pemesanan has one Kwitansi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kwitansi()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
        return $this->hasOne('App\Models\Kwitansi');
    }
}
