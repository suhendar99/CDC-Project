<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table = 'piutangs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
}
