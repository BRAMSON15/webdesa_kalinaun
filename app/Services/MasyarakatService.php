<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\InformasiDesa;
use App\Models\ProfilDesa;
use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use Illuminate\Support\Facades\Hash;

class MasyarakatService
{
    /**
     * Get dashboard statistics
     */
    public function getDashboardStats($user)
    {
        return [
            'total_pengajuan' => $user->pengajuanSurats()->count(),
            'pengajuan_diproses' => $user->pengajuanSurats()->where('status', 'diproses')->count(),
            'pengajuan_disetujui' => $user->pengajuanSurats()->where('status', 'disetujui')->count(),
            'pengajuan_ditolak' => $user->pengajuanSurats()->where('status', 'ditolak')->count(),
            'total_pengaduan' => Pengaduan::where('user_id', $user->id)->count(),
            'pengaduan_diproses' => Pengaduan::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'bansos_aktif' => Bansos::aktif()->withQuota()->count(),
            'bansos_terdaftar' => PenerimaBansos::where('user_id', $user->id)->count(),
        ];
    }

    /**
     * Get recent pengajuan
     */
    public function getRecentPengajuan($user, $limit = 5)
    {
        return $user->pengajuanSurats()
            ->with('jenisSurat')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get recent informasi
     */
    public function getRecentInformasi($limit = 3)
    {
        return InformasiDesa::published()
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get active jenis surat
     */
    public function getActiveJenisSurat()
    {
        return JenisSurat::active()->get();
    }

    /**
     * Get filtered pengajuan
     */
    public function getFilteredPengajuan($user, $filters = [])
    {
        $query = $user->pengajuanSurats()->with('jenisSurat');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['bulan'])) {
            $query->whereMonth('created_at', $filters['bulan']);
        }

        if (!empty($filters['tahun'])) {
            $query->whereYear('created_at', $filters['tahun']);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Get pengajuan detail
     */
    public function getPengajuanDetail($user, $id)
    {
        return $user->pengajuanSurats()
            ->with(['jenisSurat', 'diproses'])
            ->findOrFail($id);
    }

    /**
     * Create pengajuan
     */
    public function createPengajuan($user, $data)
    {
        $data['user_id'] = $user->id;
        return PengajuanSurat::create($data);
    }

    /**
     * Get profil desa
     */
    public function getProfilDesa()
    {
        return ProfilDesa::first();
    }

    /**
     * Get informasi desa
     */
    public function getInformasiDesa($page = 1)
    {
        return InformasiDesa::published()
            ->latest()
            ->paginate(10);
    }

    /**
     * Get informasi detail
     */
    public function getInformasiDetail($id)
    {
        return InformasiDesa::published()->findOrFail($id);
    }

    /**
     * Update user profile
     */
    public function updateProfile($user, $data)
    {
        return $user->update($data);
    }

    /**
     * Update user password
     */
    public function updatePassword($user, $currentPassword, $newPassword)
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception('Password saat ini tidak sesuai');
        }

        return $user->update(['password' => Hash::make($newPassword)]);
    }
}
