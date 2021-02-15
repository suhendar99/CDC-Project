<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuans';
    protected $guarded = [];

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
    public function storeData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
    public function storageKeluarPemasok()
    {
        return $this->hasMany('App\Models\StorageKeluarPemasok');
    }

    /**
     * Satuan has many StorageMasukRetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageMasukRetail()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = satuan_id, localKey = id)
        return $this->hasMany('App\Models\StorageIn', 'satuan_id');
    }
}
