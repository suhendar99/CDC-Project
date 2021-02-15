<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapitulasiPenjualanPemasok extends Model
{
    protected $table = 'rekapitulasi_penjualan_pemasoks';
    protected $guarded = [];

    /**
     * Get the storageKeluar that owns the RekapitulasiPenjualanPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageKeluar(): BelongsTo
    {
        return $this->belongsTo(StorageKeluarPemasok::class, 'storage_keluar_id', 'id');
    }
}
