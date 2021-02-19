<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabaRugiPelanggan extends Model
{
    protected $table = 'laba_rugi_pelanggans';
    protected $guarded = [];

    /**
     * Get the warung that owns the LabaRugiPelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warung(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'warung_id', 'id');
    }
}
