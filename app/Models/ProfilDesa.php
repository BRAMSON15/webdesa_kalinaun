<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_desa',
        'nama_kepala_desa',
        'alamat_desa',
        'kode_pos',
        'telepon',
        'email',
        'visi',
        'misi',
        'sejarah',
        'struktur_organisasi',
        'logo',
    ];

    protected $casts = [
        'struktur_organisasi' => 'array',
    ];
}
