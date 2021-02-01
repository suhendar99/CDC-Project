<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageOut extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'storage_outs';
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

    public function barangWarung()
    {
        return $this->hasMany('App\Models\BarangWarung', 'storage_out_kode', 'kode');
    }

    /**
     * StorageIn belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
    	// belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Gudang');
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
    public function pemesanan()
    {
        // belongsTo(RelatedModel, foreignKey = pemesanan_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\Pemesanan');
    }
}
