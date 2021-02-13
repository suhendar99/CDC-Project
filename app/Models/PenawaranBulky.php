<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenawaranBulky extends Model
{
    protected $table = 'penawaran_bulkies';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }
    public function gudangBulky()
    {
        return $this->belongsTo('App\Models\GudangBulky', 'gudang_bulky_id', 'id');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok', 'pemasok_id', 'id');
    }
}
