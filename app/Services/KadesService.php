<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Models\User;
use App\Models\Bansos;
use App\Models\PenerimaBansos;

class KadesService
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        return [
            'total_pengajuan' => PengajuanSurat::count(),
            'pengajuan_pending' => PengajuanSurat::where('status', 'diproses')->count(),
            'pengajuan_disetujui' => PengajuanSurat::where('status', 'disetujui')->count(),
            'pengajuan_ditolak' => PengajuanSurat::where('status', 'ditolak')->count(),
            'bansos_pending' => PenerimaBansos::where('status', 'menunggu')->count(),
        ];
    }

    /**
     * Get recent data for dashboard
     */
    public function getRecentData()
    {
        return [
            'pengajuanTerbaru' => PengajuanSurat::with(['user', 'jenisSurat'])
                ->where('status', 'diproses')
                ->latest()
                ->take(5)
                ->get(),
            'bansosTerbaru' => PenerimaBansos::with(['user', 'bansos'])
                ->where('status', 'menunggu')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

    /**
     * Update user profile
     */
    public function updateProfile($user, $data)
    {
        $user->update($data);
        return $user;
    }

    /**
     * Get pengajuan for validation
     */
    public function getPengajuanForValidasi()
    {
        return PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', 'diproses')
            ->latest()
            ->get();
    }

    /**
     * Get detail pengajuan
     */
    public function getDetailPengajuan($id)
    {
        return PengajuanSurat::with(['user', 'jenisSurat'])->findOrFail($id);
    }

    /**
     * Process pengajuan
     */
    public function processPengajuan($id, $status, $catatan, $userId)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);

        $pengajuan->update([
            'status' => $status,
            'catatan_kades' => $catatan,
            'diproses_oleh' => $userId,
            $status === 'disetujui' ? 'tanggal_disetujui' : 'tanggal_ditolak' => now(),
        ]);

        if ($status === 'disetujui') {
            $nomorSurat = $this->generateNomorSurat($pengajuan);
            $pengajuan->update(['nomor_surat' => $nomorSurat]);
        }

        return $pengajuan;
    }

    /**
     * Get bansos for validation
     */
    public function getBansosForValidasi()
    {
        return PenerimaBansos::with(['user', 'bansos'])
            ->where('status', 'menunggu')
            ->latest()
            ->get();
    }

    /**
     * Approve bansos
     */
    public function approveBansos($bansosId, $penerimaId, $catatan = null)
    {
        $bansos = Bansos::findOrFail($bansosId);
        $penerima = PenerimaBansos::findOrFail($penerimaId);
        $oldStatus = $penerima->status;

        if ($bansos->kuota_terpakai >= $bansos->kuota) {
            throw new \Exception('Kuota program bansos ini sudah penuh');
        }

        $penerima->update([
            'status' => 'disetujui',
            'alasan_penolakan' => null,
            'catatan' => $catatan ?? 'Disetujui oleh Kepala Desa',
        ]);

        $bansos->increment('kuota_terpakai');

        try {
            $this->notificationService->notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return $penerima;
    }

    /**
     * Reject bansos
     */
    public function rejectBansos($bansosId, $penerimaId, $alasan)
    {
        $bansos = Bansos::findOrFail($bansosId);
        $penerima = PenerimaBansos::findOrFail($penerimaId);
        $oldStatus = $penerima->status;

        $penerima->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $alasan,
            'catatan' => 'Ditolak oleh Kepala Desa',
        ]);

        try {
            $this->notificationService->notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return $penerima;
    }

    /**
     * Get monitoring pengaduan
     */
    public function getMonitoringPengaduan($page = 1)
    {
        return PengajuanSurat::with(['user', 'jenisSurat'])
            ->latest()
            ->paginate(10, ['*'], 'page', $page);
    }

    /**
     * Get laporan arsip
     */
    public function getLaporanArsip($filters = [])
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', '!=', 'diproses');

        if (isset($filters['bulan']) && $filters['bulan']) {
            $query->whereMonth('created_at', $filters['bulan']);
        }

        if (isset($filters['tahun']) && $filters['tahun']) {
            $query->whereYear('created_at', $filters['tahun']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->get();
    }

    /**
     * Generate nomor surat
     */
    private function generateNomorSurat($pengajuan)
    {
        $tahun = date('Y');
        $bulan = date('m');

        $counter = PengajuanSurat::where('status', 'disetujui')
            ->whereYear('tanggal_disetujui', $tahun)
            ->whereMonth('tanggal_disetujui', $bulan)
            ->count();

        $nomorUrut = str_pad($counter + 1, 3, '0', STR_PAD_LEFT);
        $jenisCode = strtoupper(substr($pengajuan->jenisSurat->nama_surat, 0, 3));

        return "{$nomorUrut}/{$jenisCode}/DESA/{$bulan}/{$tahun}";
    }
}
