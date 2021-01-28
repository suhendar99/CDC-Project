<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudangs';
    protected $guarded = [];

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }

    public function po()
    {
        return $this->hasMany('App\Models\Po');
    }


    /**
     * Gudang has many StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageIn()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
    	return $this->hasMany('App\Models\StorageIn');
    }

    /**
     * Gudang has many StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageOut()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
    	return $this->hasMany('App\Models\StorageOut');
    }

    /**
     * Gudang has many Rak.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rak()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
    	return $this->hasMany('App\Models\Rak');
    }

    /**
     * Gudang belongs to Desa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function desa()
    {
    	// belongsTo(RelatedModel, foreignKey = desa_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Models\Desa');
    }

    /**
     * Gudang belongs to AkunGudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akunGudang()
    {
        // belongsTo(RelatedModel, foreignKey = akunGudang_id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\PengurusGudang', 'akun_gudangs', 'gudang_id', 'pengurus_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Gudang has many Pemesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pemesanan()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
        return $this->hasMany('App\Models\Pemesanan');
    }

    /**
     * Gudang has many Stock.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
        return $this->hasMany('App\Models\StockBarang');
    }

    /**
     * Gudang has many Kwitansi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kwitansi()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
        return $this->hasMany('App\Models\Kwitansi');
    }
}
