<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananKeluarBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pemesanan_keluar_bulky';
    protected $guarded = [];

    /**
     * PemesananKeluarBulky belongs to Bulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = bulky_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }

    /**
     * PemesananKeluarBulky belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }
    public function storageKeluarPemasok()
    {
        return $this->hasMany('App\Models\StorageKeluarPemasok');
    }
    public function kwitansiPemasok()
    {
        return $this->hasMany('App\Models\KwitansiPemasok');
    }
    public function suratJalanPemasok()
    {
        return $this->hasMany('App\Models\SuratJalanPemasok');
    }
    public function barangKeluarPemesananBulky()
    {
        return $this->hasMany('App\Models\BarangKeluarPemesananBulky','pemesanan_id','id');
    }
}
