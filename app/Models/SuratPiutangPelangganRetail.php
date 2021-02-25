<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPiutangPelangganRetail extends Model
{
    protected $table = 'surat_piutang_pelanggan_retails';
    protected $guarded = [];

    /**
     * Get the pemesanan that owns the SuratPiutangPelangganRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'id');
    }

    /**
     * Get the storageKeluar that owns the SuratPiutangPelangganRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storageKeluar(): BelongsTo
    {
        return $this->belongsTo(StorageOut::class, 'storage_keluar_id', 'id');
    }

    /**
     * Get the user that owns the SuratPiutangPelangganRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function retail(): BelongsTo
    {
        return $this->belongsTo(PengurusGudang::class, 'retail_id', 'id');
    }

    /**
     * Get the user that owns the SuratPiutangPelangganRetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
