<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class TblAdmin extends Authenticatable
{
    protected $table = 'tbl_admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relationships
    public function arsipDokumen()
    {
        return $this->hasMany(TblArsipDokumenDesa::class, 'id_admin', 'id_admin');
    }

    // Methods sesuai Class Diagram
    public function verifikasiBerkas($idSurat, $statusVerifikasi)
    {
        $pengajuan = TblPengajuanSurat::find($idSurat);
        
        if ($pengajuan) {
            // Update status verifikasi berkas
            $pengajuan->update([
                'status_verifikasi' => $statusVerifikasi,
                'tgl_verifikasi' => now()
            ]);
            
            return true;
        }
        
        return false;
    }

    public function kelolaArsipDesa($data)
    {
        // Mengelola arsip dokumen desa (bukan surat warga)
        return $this->arsipDokumen()->create([
            'judul_dokumen' => $data['judul_dokumen'],
            'kategori' => $data['kategori'], // 'Perdes', 'SK Kades', 'Aset', 'Lainnya'
            'file_path' => $data['file_path'],
            'tgl_upload' => now()
        ]);
    }

    public function getDaftarPengajuan($status = null)
    {
        $query = TblPengajuanSurat::with('masyarakat');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->orderBy('tgl_pengajuan', 'desc')->get();
    }

    public function getDaftarArsipDesa()
    {
        return TblArsipDokumenDesa::where('id_admin', $this->id_admin)
            ->orderBy('tgl_upload', 'desc')
            ->get();
    }
}
