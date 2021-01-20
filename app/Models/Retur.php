<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'returs';
    protected $guarded = [];

    /**
     * Retur belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesanan()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Pemesanan');
    }

    /**
     * Retur belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }
}
