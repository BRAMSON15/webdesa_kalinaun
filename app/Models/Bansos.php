<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Bansos extends Model
{
    use LogsActivity;
    protected $table = 'bansos';

    protected $fillable = [
        'nama_bansos',
        'deskripsi',
        'syarat_ketentuan',
        'kuota',
        'kuota_terpakai',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'nominal',
        'jenis_bansos',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'nominal' => 'decimal:2',
    ];

    /**
     * Get all recipients for this bansos
     */
    public function penerima(): HasMany
    {
        return $this->hasMany(PenerimaBansos::class, 'bansos_id');
    }

    /**
     * Get approved recipients
     */
    public function penerimaDisetujui(): HasMany
    {
        return $this->hasMany(PenerimaBansos::class, 'bansos_id')
            ->where('status', 'disetujui');
    }

    /**
     * Scope untuk bansos aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Scope untuk bansos dengan kuota tersedia
     */
    public function scopeWithQuota($query)
    {
        return $query->whereRaw('kuota > kuota_terpakai');
    }

    /**
     * Check if bansos still has quota
     */
    public function hasQuota(): bool
    {
        return $this->kuota > $this->kuota_terpakai;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuota(): int
    {
        return $this->kuota - $this->kuota_terpakai;
    }
}
