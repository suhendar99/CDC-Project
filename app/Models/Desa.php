<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas';
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
     * Desa belongs to Kecamatan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan()
    {
        // belongsTo(RelatedModel, foreignKey = kecamatan_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\Kecamatan');
    }

    /**
     * Desa has many Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gudang()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = desa_id, localKey = id)
        return $this->hasMany('App\Models\Gudang');
    }

    /**
     * Desa has many Bulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bulky()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = desa_id, localKey = id)
        return $this->hasMany('App\Models\GudangBulky');
    }
}
