<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class TblSekdes extends Authenticatable
{
    protected $table = 'tbl_sekdes';
    protected $primaryKey = 'id_sekdes';

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

    // Methods sesuai Class Diagram
    public function validasiAkhir($idSurat, $status, $catatan = null)
    {
        $pengajuan = TblPengajuanSurat::find($idSurat);
        
        if ($pengajuan) {
            $pengajuan->update([
                'status' => $status, // 'selesai' atau 'ditolak'
                'catatan_validasi' => $catatan
            ]);

            // Kirim notifikasi email otomatis ke masyarakat
            $this->kirimNotifikasiEmail($pengajuan);
            
            return true;
        }
        
        return false;
    }

    public function lihatLaporanArsip()
    {
        // Menampilkan laporan arsip pengajuan surat
        return TblPengajuanSurat::with('masyarakat')
            ->whereIn('status', ['selesai', 'ditolak'])
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();
    }

    private function kirimNotifikasiEmail($pengajuan)
    {
        // Implementasi pengiriman email notifikasi
        // Menggunakan email dari tbl_masyarakat untuk notifikasi otomatis
        $masyarakat = $pengajuan->masyarakat;
        
        if ($masyarakat && $masyarakat->email) {
            // Logic untuk mengirim email
            // Mail::to($masyarakat->email)->send(new NotifikasiStatusSurat($pengajuan));
        }
    }
}
