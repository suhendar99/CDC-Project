<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabaRugiPemasok extends Model
{
    protected $table = 'laba_rugi_pemasoks';
    protected $guarded = [];

    /**
     * Get the pemasok that owns the LabaRugiPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemasok(): BelongsTo
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id', 'id');
    }
}
