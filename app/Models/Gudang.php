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
}
