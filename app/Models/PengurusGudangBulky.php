<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusGudangBulky extends Model
{
    protected $table = 'pengurus_gudang_bulkies';
    protected $guarded = [];

    /**
     * PengurusGudang belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky()
    {
        // belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\GudangBulky', 'akun_gudang_bulkys', 'pengurus_bulky_id', 'bulky_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','pengurus_gudang_bulky_id','id');
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

}
