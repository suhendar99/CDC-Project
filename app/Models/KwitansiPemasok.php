<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KwitansiPemasok extends Model
{
    protected $table = 'kwitansi_pemasoks';
    protected $guarded = [];

    public function pemesananKeluarBulky()
    {
        return $this->belongsTo('App\Models\PemesananKeluarBulky');
    }
    public function storageKeluarPemasok()
    {
        return $this->belongsTo('App\Models\StorageKeluarPemasok');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
