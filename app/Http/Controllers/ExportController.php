<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Export pengaduan
     */
    public function exportPengaduan(Request $request)
    {
        $format = $request->get('format', 'csv');
        $filters = [
            'status' => $request->get('status'),
            'kategori' => $request->get('kategori'),
        ];

        $pengaduans = $this->exportService->exportPengaduan($filters);

        if ($format === 'pdf') {
            return $this->exportService->exportPengaduanPDF($pengaduans);
        }

        return $this->exportService->exportPengaduanCSV($pengaduans);
    }

    /**
     * Export bansos
     */
    public function exportBansos(Request $request)
    {
        $format = $request->get('format', 'csv');
        $filters = [
            'status' => $request->get('status'),
        ];

        $bansos = $this->exportService->exportBansos($filters);

        if ($format === 'pdf') {
            return $this->exportService->exportBansosPDF($bansos);
        }

        return $this->exportService->exportBansosCSV($bansos);
    }

    /**
     * Export penerima bansos
     */
    public function exportPenerimaBansos(Request $request)
    {
        $format = $request->get('format', 'csv');
        $filters = [
            'status' => $request->get('status'),
            'bansos_id' => $request->get('bansos_id'),
        ];

        $penerima = $this->exportService->exportPenerimaBansos($filters);

        if ($format === 'pdf') {
            return $this->exportService->exportPenerimaBansosPDF($penerima);
        }

        return $this->exportService->exportPenerimaBansosCSV($penerima);
    }

    /**
     * Export pengajuan surat
     */
    public function exportPengajuanSurat(Request $request)
    {
        $format = $request->get('format', 'csv');
        $filters = [
            'status' => $request->get('status'),
        ];

        $pengajuans = $this->exportService->exportPengajuanSurat($filters);

        if ($format === 'pdf') {
            return $this->exportService->exportPengajuanSuratPDF($pengajuans);
        }

        return $this->exportService->exportPengajuanSuratCSV($pengajuans);
    }
}
