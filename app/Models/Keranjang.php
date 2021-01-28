<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs';
    protected $guarded = [];

    public function keranjangItem()
    {
        return $this->hasMany('App\Models\KeranjangItem');
    }
    public function pelanggan()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->belongsTo('App\Models\Pelanggan');
    }
    public function pengurusGudang()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->belongsTo('App\Models\PengurusGudang');
    }

}
