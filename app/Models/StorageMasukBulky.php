<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageMasukBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'storage_masuk_bulkies';
    protected $guarded = [];

    /**
     * StorageIn belongs to Barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
    	// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Barang', 'barang_kode', 'kode_barang');
    }

    /**
     * StorageIn belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }

    /**
     * StorageIn belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
    	// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\User');
    }

    /**
     * StorageIn has many Storage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageBulky()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = storageIn_id, localKey = id)
    	return $this->hasOne('App\Models\StorageBulky', 'storage_masuk_bulky_kode', 'kode');
    }

    public function rekapitulasi()
    {
    	return $this->hasMany('App\Models\RekapitulasiPembelian');
    }
}
