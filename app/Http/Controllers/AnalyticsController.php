<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display analytics dashboard
     */
    public function index()
    {
        $pengaduanStats = $this->analyticsService->getPengaduanStats();
        $pengaduanByKategori = $this->analyticsService->getPengaduanByKategori();
        $bansosStats = $this->analyticsService->getBansosStats();
        $pengajuanStats = $this->analyticsService->getPengajuanStats();
        $userStats = $this->analyticsService->getUserStats();
        $pengaduanTrend = $this->analyticsService->getPengaduanTrend();
        $bansosTrend = $this->analyticsService->getBansosTrend();
        $topPrograms = $this->analyticsService->getTopPrograms();
        $topJenisSurat = $this->analyticsService->getTopJenisSurat();

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
        $period = $request->get('period', '7');

        $data = $this->analyticsService->getAnalyticsData($type, $period);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Export analytics to PDF
     */
    public function exportPDF()
    {
        $pengaduanStats = $this->analyticsService->getPengaduanStats();
        $bansosStats = $this->analyticsService->getBansosStats();
        $pengajuanStats = $this->analyticsService->getPengajuanStats();
        $userStats = $this->analyticsService->getUserStats();

        return view('admin.analytics-pdf', compact(
            'pengaduanStats',
            'bansosStats',
            'pengajuanStats',
            'userStats'
        ));
    }
}
