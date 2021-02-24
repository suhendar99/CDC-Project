<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PiutangRetail extends Model
{
    protected $table = 'piutang_retails';
    protected $guarded = [];

    /**
     * Get the pemesananRetail that owns the PiutangRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananRetail(): BelongsTo
    {
        return $this->belongsTo(PemesananBulky::class, 'pemesanan_keluar_id', 'id');
    }
}
