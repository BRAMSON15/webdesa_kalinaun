<?php

namespace App\Services;

use App\Models\User;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\ProfilDesa;
use App\Models\InformasiDesa;
use App\Models\ArsipDokumen;
use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        return [
            'total_users' => User::count(),
            'total_pengajuan' => PengajuanSurat::count(),
            'pengajuan_pending' => PengajuanSurat::where('status', 'diproses')->count(),
            'total_informasi' => InformasiDesa::count(),
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_baru' => Pengaduan::where('status', 'baru')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            'total_bansos' => Bansos::count(),
            'bansos_aktif' => Bansos::where('status', 'aktif')->count(),
            'total_penerima_bansos' => PenerimaBansos::count(),
            'penerima_disetujui' => PenerimaBansos::where('status', 'disetujui')->count(),
        ];
    }

    /**
     * Get recent data for dashboard
     */
    public function getRecentData()
    {
        return [
            'pengajuanTerbaru' => PengajuanSurat::with(['user', 'jenisSurat'])->latest()->take(5)->get(),
            'pengaduanTerbaru' => Pengaduan::with('user')->latest()->take(5)->get(),
            'bansosAktif' => Bansos::where('status', 'aktif')->latest()->take(5)->get(),
        ];
    }

    /**
     * Get profil desa
     */
    public function getProfilDesa()
    {
        return ProfilDesa::first();
    }

    /**
     * Update profil desa
     */
    public function updateProfilDesa($data)
    {
        $profil = ProfilDesa::first();
        if ($profil) {
            $profil->update($data);
        } else {
            ProfilDesa::create($data);
        }
        return $profil;
    }

    /**
     * Get all pengajuan surat
     */
    public function getPengajuanSurat()
    {
        return PengajuanSurat::with(['user', 'jenisSurat'])->latest()->get();
    }

    /**
     * Get all informasi desa
     */
    public function getInformasiDesa()
    {
        return InformasiDesa::with('creator')->latest()->get();
    }

    /**
     * Create informasi desa
     */
    public function createInformasi($data, $userId)
    {
        $data['created_by'] = $userId;

        if (isset($data['gambar'])) {
            $data['gambar'] = $data['gambar']->store('informasi', 'public');
        }

        return InformasiDesa::create($data);
    }

    /**
     * Get informasi desa by id
     */
    public function getInformasiById($id)
    {
        return InformasiDesa::with('creator')->findOrFail($id);
    }

    /**
     * Update informasi desa
     */
    public function updateInformasi($id, $data)
    {
        $informasi = InformasiDesa::findOrFail($id);

        if (isset($data['gambar'])) {
            if ($informasi->gambar) {
                Storage::disk('public')->delete($informasi->gambar);
            }
            $data['gambar'] = $data['gambar']->store('informasi', 'public');
        }

        $informasi->update($data);
        return $informasi;
    }

    /**
     * Delete informasi desa
     */
    public function deleteInformasi($id)
    {
        $informasi = InformasiDesa::findOrFail($id);

        if ($informasi->gambar) {
            Storage::disk('public')->delete($informasi->gambar);
        }

        $informasi->delete();
        return true;
    }

    /**
     * Get all users
     */
    public function getAllUsers()
    {
        return User::latest()->get();
    }

    /**
     * Update user
     */
    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            throw new \Exception('Tidak dapat mengubah data admin');
        }

        $user->update($data);
        return $user;
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            throw new \Exception('Tidak dapat menghapus data admin');
        }

        $activePengajuan = PengajuanSurat::where('user_id', $id)
            ->whereIn('status', ['proses', 'diproses'])
            ->count();

        if ($activePengajuan > 0) {
            throw new \Exception('Tidak dapat menghapus pengguna yang memiliki pengajuan aktif');
        }

        $user->delete();
        return true;
    }

    /**
     * Reset user password
     */
    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            throw new \Exception('Tidak dapat reset password admin');
        }

        $tempPassword = 'Desa' . date('Ymd') . rand(1000, 9999);
        $user->update(['password' => bcrypt($tempPassword)]);

        return $tempPassword;
    }

    /**
     * Get all jenis surat
     */
    public function getJenisSurat()
    {
        return JenisSurat::latest()->get();
    }

    /**
     * Create jenis surat
     */
    public function createJenisSurat($data)
    {
        return JenisSurat::create($data);
    }

    /**
     * Get jenis surat by id
     */
    public function getJenisSuratById($id)
    {
        return JenisSurat::findOrFail($id);
    }

    /**
     * Update jenis surat
     */
    public function updateJenisSurat($id, $data)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->update($data);
        return $jenisSurat;
    }

    /**
     * Delete jenis surat
     */
    public function deleteJenisSurat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();
        return true;
    }

    /**
     * Get pengajuan surat for printing
     */
    public function getPengajuanForPrint($id)
    {
        $pengajuan = PengajuanSurat::with(['user', 'jenisSurat'])->findOrFail($id);

        if ($pengajuan->status !== 'disetujui') {
            throw new \Exception('Surat belum disetujui');
        }

        return $pengajuan;
    }

    /**
     * Get all arsip dokumen
     */
    public function getArsipDokumen()
    {
        return ArsipDokumen::with('uploader')->latest()->get();
    }

    /**
     * Create arsip dokumen
     */
    public function createArsip($data, $userId)
    {
        $file = $data['file'];
        $filePath = $file->store('arsip', 'public');

        return ArsipDokumen::create([
            'nama_dokumen' => $data['nama_dokumen'],
            'nomor_dokumen' => $data['nomor_dokumen'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'kategori' => $data['kategori'],
            'tanggal_dokumen' => $data['tanggal_dokumen'],
            'uploaded_by' => $userId,
        ]);
    }
}
