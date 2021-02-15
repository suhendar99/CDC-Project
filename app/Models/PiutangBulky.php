<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PiutangBulky extends Model
{
    protected $table = 'piutang_bulkies';
    protected $guarded = [];

    /**
     * Get the pemesananKeluarBulky that owns the PiutangBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananKeluarBulky(): BelongsTo
    {
        return $this->belongsTo(PemesananKeluarBulky::class, 'pemesanan_keluar_id', 'id');
    }
}
