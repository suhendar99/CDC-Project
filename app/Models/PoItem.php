<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoItem extends Model
{
	protected $table = 'po_items';
    protected $guarded = [];

    public function po()
    {
        return $this->belongsTo('App\Models\Po');
    }
}
