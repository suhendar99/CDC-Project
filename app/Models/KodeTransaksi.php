<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeTransaksi extends Model
{
    protected $table = 'kode_transaksis';
    protected $guarded = [];

    public function getData()
    {
        return static::orderBy('id','desc')->get();
    }
    public function storeData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
