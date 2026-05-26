<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaBansos extends Model
{
    protected $table = 'penerima_bansos';

    protected $fillable = [
        'bansos_id',
        'user_id',
        'nik',
        'nama_penerima',
        'alamat',
        'no_hp',
        'status',
        'alasan_penolakan',
        'nominal_diterima',
        'tanggal_penerimaan',
        'bukti_penerimaan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_penerimaan' => 'date',
        'nominal_diterima' => 'decimal:2',
    ];

    /**
     * Get the bansos program
     */
    public function bansos(): BelongsTo
    {
        return $this->belongsTo(Bansos::class, 'bansos_id');
    }

    /**
     * Get the user/recipient
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk penerima yang disetujui
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope untuk penerima yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope untuk penerima yang menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }
}
