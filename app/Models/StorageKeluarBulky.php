<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageKeluarBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'storage_keluar_bulkies';
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
     * StorageOut belongs to Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky()
    {
        // belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\PemesananBulky', 'pemesanan_bulky_id');
    }

    /**
     * StorageKeluarBulky has many RekapitulasiPenjualanBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rekapitulasiPenjualanBulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = storageKeluarBulky_id, localKey = id)
        return $this->hasMany('App\Models\RekapitulasiPenjualanBulky', 'storage_keluar_bulky_id');
    }
}
