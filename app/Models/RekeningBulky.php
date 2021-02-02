<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningBulky extends Model
{
    protected $table = 'rekening_bulkies';
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    public function bulky()
    {
        return $this->belongsTo('App\Models\GudangBulky', 'bulky_id');
    }
}
