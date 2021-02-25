<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function returKeluar(): HasMany
    {
        return $this->hasMany(ReturKeluarBulky::class, 'storage_masuk_id', 'id');
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
    	return $this->hasMany('App\Models\RekapitulasiPembelianBulky', 'storage_masuk_bulky_id');
    }
    /**
     * Get the pemesanan that owns the StorageMasukBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(PemesananKeluarBulky::class, 'pemesanan_keluar_bulky_id', 'id');
    }
}
