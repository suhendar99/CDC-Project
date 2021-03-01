<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PemesananBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pemesanan_bulkies';
    protected $guarded = [];

    /**
     * PemesananBulky belongs to Retail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function retail()
    {
    	// belongsTo(RelatedModel, foreignKey = retail_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Gudang', 'gudang_retail_id');
    }

    /**
     * PemesananBulky belongs to Bulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = bulky_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }

    /**
     * PemesananBulky has many BarangPesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangPesananBulky()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
    	return $this->hasOne('App\Models\BarangPemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many StorageMasukRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageMasukRetail()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
    	return $this->hasMany('App\Models\StorageIn', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many StorageKeluarBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageKeluarBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
        return $this->hasOne('App\Models\StorageKeluarBulky', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many KwitansiBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kwitansiBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
        return $this->hasMany('App\Models\KwitansiBulky', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many SuratJalanBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratJalanBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
        return $this->hasMany('App\Models\SuratJalanBulky', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many ReturMasukBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returMasukBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
        return $this->hasMany('App\Models\ReturMasukBulky', 'pemesanan_bulky_id');
    }
    /**
     * Get the piutangRetail associated with the PemesananBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function piutangRetail(): HasOne
    {
        return $this->hasOne(PiutangRetail::class, 'pemesanan_keluar_id', 'id');
    }
    /**
     * Get all of the suratPiutangRetail for the PemesananBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratPiutangRetail(): HasMany
    {
        return $this->hasMany(SuratPiutangRetailBulky::class, 'pemesanan_bulky_id', 'id');
    }
}
