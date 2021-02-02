<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    	return $this->hasMany('App\Models\BarangPemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * PemesananBulky has many StorageMasukRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageMasukRetail()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = pemesananBulky_id, localKey = id)
    	return $this->hasMany('App\Models\StorageIn', 'pemesanan_id');
    }
}
