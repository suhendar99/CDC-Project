<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GudangBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gudang_bulkies';
    protected $guarded = [];

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
    public function akunGudangBulky()
    {
        // belongsTo(RelatedModel, foreignKey = akunGudang_id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\PengurusGudangBulky', 'akun_gudang_bulkys', 'bulky_id', 'pengurus_bulky_id');
    }

    /**
     * Gudang has many Rak.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rak()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudang_id, localKey = id)
    	return $this->hasMany('App\Models\RakBulky', 'gudang_bulky_id', 'id');
    }

    /**
     * GudangBulky has many Rekening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rekening()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudangBulky_id, localKey = id)
    	return $this->hasMany('App\Models\RekeningBulky', 'bulky_id');
    }

    /**
     * GudangBulky belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
    	// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * GudangBulky has many Stock.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudangBulky_id, localKey = id)
    	return $this->hasMany('App\Models\StockBarangBulky', 'bulky_id');
    }

    /**
     * GudangBulky has many PemesananBulky.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pemesananBulky()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = gudangBulky_id, localKey = id)
    	return $this->hasMany('App\Models\PemesananBulky', 'bulky_id');
    }
}
