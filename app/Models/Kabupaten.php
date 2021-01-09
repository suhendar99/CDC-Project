<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupatens';
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
     * Kabupaten belongs to Provinsi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provinsi()
    {
        // belongsTo(RelatedModel, foreignKey = provinsi_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\Provinsi');
    }

    /**
     * Kabupaten has many Kecamatan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kecamatan()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = kabupaten_id, localKey = id)
        return $this->hasMany('App\Models\Kecamatan');
    }
}
