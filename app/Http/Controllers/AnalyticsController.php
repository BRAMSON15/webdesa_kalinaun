<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Build queries
        $pengaduanQuery = Pengaduan::query();
        $bansosQuery = PenerimaBansos::query();
        $pengajuanQuery = PengajuanSurat::query();

        // Apply date filters
        if ($startDate && $endDate) {
            $pengaduanQuery->whereBetween('tanggal_pengaduan', [$startDate, $endDate]);
            $bansosQuery->whereBetween('created_at', [$startDate, $endDate]);
            $pengajuanQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Statistics
        $stats = [
            'total_pengaduan' => $pengaduanQuery->count(),
            'pengaduan_selesai' => (clone $pengaduanQuery)->where('status', 'selesai')->count(),
            'total_bansos' => Bansos::count(),
            'total_penerima_bansos' => $bansosQuery->count(),
        ];

        // Chart data
        $chartData = [
            'pengaduan_baru' => (clone $pengaduanQuery)->where('status', 'baru')->count(),
            'pengaduan_diproses' => (clone $pengaduanQuery)->where('status', 'diproses')->count(),
            'pengaduan_selesai' => (clone $pengaduanQuery)->where('status', 'selesai')->count(),
            'pengaduan_ditolak' => (clone $pengaduanQuery)->where('status', 'ditolak')->count(),
            
            'kategori_layanan' => (clone $pengaduanQuery)->where('kategori', 'layanan')->count(),
            'kategori_infrastruktur' => (clone $pengaduanQuery)->where('kategori', 'infrastruktur')->count(),
            'kategori_kesehatan' => (clone $pengaduanQuery)->where('kategori', 'kesehatan')->count(),
            'kategori_pendidikan' => (clone $pengaduanQuery)->where('kategori', 'pendidikan')->count(),
            'kategori_lainnya' => (clone $pengaduanQuery)->where('kategori', 'lainnya')->count(),
            
            'bansos_menunggu' => (clone $bansosQuery)->where('status', 'menunggu')->count(),
            'bansos_disetujui' => (clone $bansosQuery)->where('status', 'disetujui')->count(),
            'bansos_ditolak' => (clone $bansosQuery)->where('status', 'ditolak')->count(),
            
            'pengajuan_pending' => (clone $pengajuanQuery)->where('status', 'diproses')->count(),
            'pengajuan_disetujui' => (clone $pengajuanQuery)->where('status', 'disetujui')->count(),
            'pengajuan_ditolak' => (clone $pengajuanQuery)->where('status', 'ditolak')->count(),
        ];

        return view('admin.analytics', compact('stats', 'chartData'));
    }
}
