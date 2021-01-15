<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningGudang extends Model
{
    protected $table = 'rekening_gudangs';
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
    public function gudang()
    {
        return $this->belongsTo('App\Models\Gudang');
    }
}
