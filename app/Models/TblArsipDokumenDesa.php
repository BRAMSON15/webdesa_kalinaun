<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblArsipDokumenDesa extends Model
{
    protected $table = 'tbl_arsip_dokumen_desa';
    protected $primaryKey = 'id_arsip';

    protected $fillable = [
        'judul_dokumen',
        'kategori',
        'file_path',
        'id_admin',
        'tgl_upload'
    ];

    protected $casts = [
        'tgl_upload' => 'datetime'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(TblAdmin::class, 'id_admin', 'id_admin');
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Helper methods
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeAttribute()
    {
        $filePath = storage_path('app/public/' . $this->file_path);
        
        if (file_exists($filePath)) {
            return filesize($filePath);
        }
        
        return 0;
    }

    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    // Static method untuk mendapatkan kategori yang tersedia
    public static function getKategoriOptions()
    {
        return [
            'Perdes' => 'Peraturan Desa',
            'SK Kades' => 'Surat Keputusan Kepala Desa',
            'Aset' => 'Dokumen Aset Desa',
            'Lainnya' => 'Dokumen Lainnya'
        ];
    }
}
