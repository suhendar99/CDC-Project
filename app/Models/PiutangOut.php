<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiutangOut extends Model
{
    protected $table = 'piutang_outs';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo('App\Models\PoItem');
    }
    public function po()
    {
        return $this->belongsTo('App\Models\Po','barang_id');
    }
}
