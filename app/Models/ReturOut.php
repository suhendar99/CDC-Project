<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturOut extends Model
{
    protected $table = 'retur_outs';
    protected $guarded = [];

    public function po()
    {
    	// belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Po');
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
