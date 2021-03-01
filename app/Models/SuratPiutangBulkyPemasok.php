<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPiutangBulkyPemasok extends Model
{
    protected $table = 'surat_piutang_bulky_pemasoks';
    protected $guarded = [];

    /**
     * Get the pemesananKeluarBulky that owns the SuratPiutangBulkyPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesananKeluarBulky(): BelongsTo
    {
        return $this->belongsTo(PemesananKeluarBulky::class, 'pemesanan_keluar_bulky_id', 'id');
    }
    /**
     * Get the storageKeluar that owns the SuratPiutangBulkyPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageKeluar(): BelongsTo
    {
        return $this->belongsTo(StorageKeluarPemasok::class, 'storage_keluar_pemasok_id', 'id');
    }

    /**
     * Get the pemasok that owns the SuratPiutangBulkyPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemasok(): BelongsTo
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id', 'id');
    }
    /**
     * Get the user that owns the SuratPiutangBulkyPemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
