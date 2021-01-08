<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];
    public function barang()
    {
        return $this->belongsTo('App\Models\Barang',);
    }
}
