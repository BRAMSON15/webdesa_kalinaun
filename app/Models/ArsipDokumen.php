<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokumen',
        'nomor_dokumen',
        'deskripsi',
        'file_path',
        'file_type',
        'file_size',
        'kategori',
        'tanggal_dokumen',
        'uploaded_by',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];

    // Relationships
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
