<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabaRugiBulky extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laba_rugi_bulkies';
    protected $guarded = [];

    /**
     * Get the bulky that owns the LabaRugiBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky(): BelongsTo
    {
        return $this->belongsTo(PengurusGudangBulky::class, 'bulky_id', 'id');
    }
}
