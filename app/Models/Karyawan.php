<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
