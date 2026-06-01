<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    protected $table = 'tanda_tangan';

    protected $fillable = [
        'admin_id',
        'nama_penanda_tangan',
        'jabatan',
        'nip',
        'signature_image',
        'signature_type',
        'is_active',
        'berlaku_dari',
        'berlaku_sampai',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'berlaku_dari' => 'datetime',
        'berlaku_sampai' => 'datetime',
    ];

    /**
     * Get the admin who created this signature
     */
    public function admin()
    {
        return $this->belongsTo(TblAdmin::class, 'admin_id');
    }

    /**
     * Check if signature is currently valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->berlaku_dari && $now < $this->berlaku_dari) {
            return false;
        }

        if ($this->berlaku_sampai && $now > $this->berlaku_sampai) {
            return false;
        }

        return true;
    }

    /**
     * Get active signatures
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('berlaku_dari')
                    ->orWhere('berlaku_dari', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('berlaku_sampai')
                    ->orWhere('berlaku_sampai', '>=', now());
            });
    }

    /**
     * Get digital signatures
     */
    public function scopeDigital($query)
    {
        return $query->where('signature_type', 'digital');
    }

    /**
     * Get scanned signatures
     */
    public function scopeScanned($query)
    {
        return $query->where('signature_type', 'scanned');
    }
}
