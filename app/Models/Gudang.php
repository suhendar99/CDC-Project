<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudangs';
    protected $guarded = [];

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
}
