<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningPemasok extends Model
{
    protected $table = 'rekening_pemasoks';
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
}
