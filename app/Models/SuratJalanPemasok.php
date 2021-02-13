<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanPemasok extends Model
{
    protected $table = 'surat_jalan_pemasoks';
    protected $guarded = [];

    public function pemesananKeluarBulky()
    {
        return $this->belongsTo('App\Models\PemesananKeluarBulky');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
