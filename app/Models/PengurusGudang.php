<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengurusGudang extends Model
{
    protected $table = 'pengurus_gudangs';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User','pengurus_gudang_id','id');
    }

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }

    /**
     * Get all of the comments for the PengurusGudang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labaRugiRetail(): HasMany
    {
        return $this->hasMany(labaRugiRetail::class, 'retail_id', 'id');
    }
    public function desa()
    {
        return $this->belongsTo('App\Models\Desa');
    }
    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan');
    }
    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten');
    }
    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi');
    }

    /**
     * PengurusGudang belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
        // belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\Gudang', 'akun_gudangs', 'pengurus_id', 'gudang_id');
    }

    public function suratPiutangPelangganRetail(): HasMany
    {
        return $this->hasMany(SuratPiutangPelangganRetail::class, 'retail_id', 'id');
    }
}
