<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasoks';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User','pemasok_id');
    }
    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
