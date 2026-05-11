<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surat',
        'deskripsi',
        'persyaratan',
        'is_active',
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
