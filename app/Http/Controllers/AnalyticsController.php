<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index()
    {
        // Pengaduan Statistics
        $pengaduanStats = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        // Pengaduan by kategori
        $pengaduanByKategori = Pengaduan::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();

        // Bansos Statistics
        $bansosStats = [
            'total_program' => Bansos::count(),
            'program_aktif' => Bansos::where('status', 'aktif')->count(),
            'total_penerima' => PenerimaBansos::count(),
            'penerima_disetujui' => PenerimaBansos::where('status', 'disetujui')->count(),
            'total_nominal' => PenerimaBansos::where('status', 'disetujui')->sum('nominal_diterima'),
        ];

        // Pengajuan Surat Statistics
        $pengajuanStats = [
            'total' => PengajuanSurat::count(),
            'proses' => PengajuanSurat::where('status', 'proses')->count(),
            'disetujui' => PengajuanSurat::where('status', 'disetujui')->count(),
            'ditolak' => PengajuanSurat::where('status', 'ditolak')->count(),
        ];

        // User Statistics
        $userStats = [
            'total_user' => User::count(),
            'masyarakat' => User::where('role', 'masyarakat')->count(),
            'kades' => User::where('role', 'kades')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        // Pengaduan trend (last 7 days)
        $pengaduanTrend = Pengaduan::selectRaw('DATE(tanggal_pengaduan) as date, COUNT(*) as total')
            ->where('tanggal_pengaduan', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Bansos trend (last 7 days)
        $bansosTrend = PenerimaBansos::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top programs
        $topPrograms = Bansos::withCount('penerima')
            ->orderBy('penerima_count', 'desc')
            ->limit(5)
            ->get();

        // Top jenis surat
        $topJenisSurat = PengajuanSurat::selectRaw('jenis_surat_id, COUNT(*) as total')
            ->groupBy('jenis_surat_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('jenisSurat')
            ->get();

        return view('admin.analytics', compact(
            'pengaduanStats',
            'pengaduanByKategori',
            'bansosStats',
            'pengajuanStats',
            'userStats',
            'pengaduanTrend',
            'bansosTrend',
            'topPrograms',
            'topJenisSurat'
        ));
    }

    /**
     * Get analytics data for API
     */
    public function getAnalyticsData(Request $request)
    {
        $type = $request->get('type', 'pengaduan');
        $period = $request->get('period', '7'); // days

        $data = [];

        switch ($type) {
            case 'pengaduan':
                $data = $this->getPengaduanAnalytics($period);
                break;
            case 'bansos':
                $data = $this->getBansosAnalytics($period);
                break;
            case 'pengajuan':
                $data = $this->getPengajuanAnalytics($period);
                break;
            default:
                $data = [];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get pengaduan analytics
     */
    private function getPengaduanAnalytics($days)
    {
        return Pengaduan::selectRaw('DATE(tanggal_pengaduan) as date, status, COUNT(*) as total')
            ->where('tanggal_pengaduan', '>=', now()->subDays($days))
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get bansos analytics
     */
    private function getBansosAnalytics($days)
    {
        return PenerimaBansos::selectRaw('DATE(created_at) as date, status, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get pengajuan analytics
     */
    private function getPengajuanAnalytics($days)
    {
        return PengajuanSurat::selectRaw('DATE(created_at) as date, status, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();
    }

    /**
     * Export analytics to PDF
     */
    public function exportPDF()
    {
        $pengaduanStats = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        $bansosStats = [
            'total_program' => Bansos::count(),
            'program_aktif' => Bansos::where('status', 'aktif')->count(),
            'total_penerima' => PenerimaBansos::count(),
            'penerima_disetujui' => PenerimaBansos::where('status', 'disetujui')->count(),
            'total_nominal' => PenerimaBansos::where('status', 'disetujui')->sum('nominal_diterima'),
        ];

        $pengajuanStats = [
            'total' => PengajuanSurat::count(),
            'proses' => PengajuanSurat::where('status', 'proses')->count(),
            'disetujui' => PengajuanSurat::where('status', 'disetujui')->count(),
            'ditolak' => PengajuanSurat::where('status', 'ditolak')->count(),
        ];

        $userStats = [
            'total_user' => User::count(),
            'masyarakat' => User::where('role', 'masyarakat')->count(),
            'kades' => User::where('role', 'kades')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        return view('admin.analytics-pdf', compact(
            'pengaduanStats',
            'bansosStats',
            'pengajuanStats',
            'userStats'
        ));
    }
}
