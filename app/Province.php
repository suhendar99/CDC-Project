<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $guarded = [];
    public function barang()
    {
        return $this->belongsTo('App\Models\Barang',);
    }
}
