<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * PengurusGudang belongs to Gudang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gudang()
    {
        // belongsTo(RelatedModel, foreignKey = gudang_id, keyOnRelatedModel = id)
        return $this->belongsToMany('App\Models\Gudang', 'akun_gudangs', 'pengurus_id', 'gudang_id');
    }
}
