<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoBarang extends Model
{
    protected $table = 'foto_barangs';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
}
