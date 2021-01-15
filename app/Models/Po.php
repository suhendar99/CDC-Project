<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $table = 'pos';
    protected $guarded = [];

    public function po_item()
    {
        return $this->hasMany('App\Models\PoItem');
    }
    public function piutang()
    {
        return $this->hasMany('App\Models\Piutang');
    }

    public function gudang()
    {
        return $this->belongsTo('App\Models\Gudang');
    }


}
