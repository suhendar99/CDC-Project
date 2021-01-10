<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsis';
    protected $guarded = [];

    public function pemasok()
    {
        return $this->hasMany('App\Models\Pemasok');
    }
    public function pelanggan()
    {
        return $this->hasMany('App\Models\Pelanggan');
    }

    /**
     * Provinsi has many Kabupater.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kabupaten()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = provinsi_id, localKey = id)
        return $this->hasMany('App\Models\Kabupaten');
    }
}
