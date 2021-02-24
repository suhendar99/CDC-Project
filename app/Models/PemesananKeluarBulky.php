<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->hasOne('App\Models\StorageKeluarPemasok');
    }
    public function kwitansiPemasok()
    {
        return $this->hasOne('App\Models\KwitansiPemasok');
    }
    public function suratJalanPemasok()
    {
        return $this->hasOne('App\Models\SuratJalanPemasok');
    }
    public function barangKeluarPemesananBulky()
    {
        return $this->hasMany('App\Models\BarangKeluarPemesananBulky','pemesanan_id','id');
    }
    /**
     * Get all of the piutangBulky for the PemesananKeluarBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piutangBulky(): HasOne
    {
        return $this->hasOne(PiutangBulky::class, 'pemesanan_keluar_id', 'id');
    }
    /**
     * Get all of the suratPiutangBulkyPemasok for the PemesananKeluarBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratPiutangBulkyPemasok(): HasMany
    {
        return $this->hasMany(SuratPiutangBulkyPemasok::class, 'pemesanan_keluar_bulky_id', 'id');
    }
}
