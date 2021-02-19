<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabaRugiRetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laba_rugi_retails';
    protected $guarded = [];

    /**
     * Get the retail that owns the LabaRugiRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function retail(): BelongsTo
    {
        return $this->belongsTo(PengurusGudang::class, 'retail_id', 'id');
    }
}
