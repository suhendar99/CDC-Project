<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPiutangRetailBulky extends Model
{
    protected $table = 'surat_piutang_retail_bulkies';
    protected $guarded = [];

    /**
     * Get the bulky that owns the SuratPiutangRetailBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananBulky(): BelongsTo
    {
        return $this->belongsTo(PemesananBulky::class, 'pemesanan_bulky_id', 'id');
    }

    /**
     * Get the storageKeluarBulky that owns the SuratPiutangRetailBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageKeluarBulky(): BelongsTo
    {
        return $this->belongsTo(StorageKeluarBulky::class, 'storage_keluar_bulky_id', 'id');
    }

    /**
     * Get the bulky that owns the SuratPiutangRetailBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bulky(): BelongsTo
    {
        return $this->belongsTo(PengurusGudangBulky::class, 'bulky_id', 'id');
    }

    /**
     * Get the user that owns the SuratPiutangRetailBulky
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
