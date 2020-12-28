<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasoks';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
