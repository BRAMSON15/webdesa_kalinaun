<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPengajuanSurat extends Model
{
    protected $table = 'tbl_pengajuan_surat';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'id_masyarakat',
        'keterangan',
        'tgl_pengajuan',
        'jenis_surat',
        'status',
        'status_verifikasi',
        'tgl_verifikasi',
        'catatan_validasi'
    ];

    protected $casts = [
        'tgl_pengajuan' => 'date',
        'tgl_verifikasi' => 'datetime'
    ];

    // Relationships
    public function masyarakat()
    {
        return $this->belongsTo(TblMasyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }

    // Methods sesuai Class Diagram
    public function cekStatus()
    {
        return [
            'id_surat' => $this->id_surat,
            'status' => $this->status,
            'tgl_pengajuan' => $this->tgl_pengajuan,
            'jenis_surat' => $this->jenis_surat,
            'keterangan' => $this->keterangan,
            'status_verifikasi' => $this->status_verifikasi ?? 'Belum diverifikasi',
            'catatan_validasi' => $this->catatan_validasi
        ];
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByMasyarakat($query, $idMasyarakat)
    {
        return $query->where('id_masyarakat', $idMasyarakat);
    }

    // Helper methods
    public function isProses()
    {
        return $this->status === 'proses';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'proses':
                return '<span class="badge bg-warning">Sedang Diproses</span>';
            case 'selesai':
                return '<span class="badge bg-success">Selesai</span>';
            case 'ditolak':
                return '<span class="badge bg-danger">Ditolak</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }
}
