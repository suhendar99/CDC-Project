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
     * Pemesanan has many Kwitansi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kwitansi()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->hasMany('App\Models\Kwitansi');
    }

    /**
     * Pemesanan has many SuratJalan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratJalan()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->hasMany('App\Models\SuratJalan');
    }

    /**
     * Pemesanan has many StorageOut.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageOut()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->hasMany('App\Models\StorageOut');
    }

    public function piutang()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
    	return $this->hasMany('App\Models\Piutang','barang_id','id');
    }
}
