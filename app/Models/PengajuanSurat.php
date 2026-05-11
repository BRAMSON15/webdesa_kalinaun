<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'nomor_surat',
        'keperluan',
        'data_formulir',
        'dokumen_pendukung',
        'status',
        'catatan_kades',
        'tanggal_disetujui',
        'tanggal_ditolak',
        'diproses_oleh',
    ];

    protected $casts = [
        'data_formulir' => 'array',
        'dokumen_pendukung' => 'array',
        'tanggal_disetujui' => 'datetime',
        'tanggal_ditolak' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function diproses()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
