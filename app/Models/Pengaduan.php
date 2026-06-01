<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    protected $table = 'pengaduans';
    
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'status',
        'catatan_admin',
        'admin_id',
        'tanggal_pengaduan',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Get the user who filed the complaint
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who handled the complaint
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk pengaduan baru
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'baru')->orderBy('tanggal_pengaduan', 'desc');
    }
}
