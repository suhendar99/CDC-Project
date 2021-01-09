<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';
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
     * Kecamatan belongs to Kabupaten.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabupaten()
    {
        // belongsTo(RelatedModel, foreignKey = kabupaten_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Models\Kabupaten');
    }

    /**
     * Kecamatan has many Desa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desa()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = kecamatan_id, localKey = id)
        return $this->hasMany('App\Models\Desa');
    }
}
