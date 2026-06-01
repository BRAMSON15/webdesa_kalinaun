<?php

namespace App\Services;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use App\Models\User;

class AnalyticsService
{
    /**
     * Get pengaduan statistics
     */
    public function getPengaduanStats()
    {
        return [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get pengaduan by kategori
     */
    public function getPengaduanByKategori()
    {
        return Pengaduan::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();
    }

    /**
     * Get bansos statistics
     */
    public function getBansosStats()
    {
        return [
            'total_program' => Bansos::count(),
            'program_aktif' => Bansos::where('status', 'aktif')->count(),
            'total_penerima' => PenerimaBansos::count(),
            'penerima_disetujui' => PenerimaBansos::where('status', 'disetujui')->count(),
            'total_nominal' => PenerimaBansos::where('status', 'disetujui')->sum('nominal_diterima'),
        ];
    }

    /**
     * Get pengajuan statistics
     */
    public function getPengajuanStats()
    {
        return [
            'total' => PengajuanSurat::count(),
            'proses' => PengajuanSurat::where('status', 'proses')->count(),
            'disetujui' => PengajuanSurat::where('status', 'disetujui')->count(),
            'ditolak' => PengajuanSurat::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        return [
            'total_user' => User::count(),
            'masyarakat' => User::where('role', 'masyarakat')->count(),
            'kades' => User::where('role', 'kades')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];
    }

    /**
     * Get pengaduan trend
     */
    public function getPengaduanTrend($days = 7)
    {
        return Pengaduan::selectRaw('DATE(tanggal_pengaduan) as date, COUNT(*) as total')
            ->where('tanggal_pengaduan', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get bansos trend
     */
    public function getBansosTrend($days = 7)
    {
        return PenerimaBansos::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get top programs
     */
    public function getTopPrograms($limit = 5)
    {
        return Bansos::withCount('penerima')
            ->orderBy('penerima_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get top jenis surat
     */
    public function getTopJenisSurat($limit = 5)
    {
        return PengajuanSurat::selectRaw('jenis_surat_id, COUNT(*) as total')
            ->groupBy('jenis_surat_id')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->with('jenisSurat')
            ->get();
    }

    /**
     * Get analytics data by type
     */
    public function getAnalyticsData($type, $days = 7)
    {
        switch ($type) {
            case 'pengaduan':
                return Pengaduan::selectRaw('DATE(tanggal_pengaduan) as date, status, COUNT(*) as total')
                    ->where('tanggal_pengaduan', '>=', now()->subDays($days))
                    ->groupBy('date', 'status')
                    ->orderBy('date')
                    ->get();
            case 'bansos':
                return PenerimaBansos::selectRaw('DATE(created_at) as date, status, COUNT(*) as total')
                    ->where('created_at', '>=', now()->subDays($days))
                    ->groupBy('date', 'status')
                    ->orderBy('date')
                    ->get();
            case 'pengajuan':
                return PengajuanSurat::selectRaw('DATE(created_at) as date, status, COUNT(*) as total')
                    ->where('created_at', '>=', now()->subDays($days))
                    ->groupBy('date', 'status')
                    ->orderBy('date')
                    ->get();
            default:
                return [];
        }
    }
}
