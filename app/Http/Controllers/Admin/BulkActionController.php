<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BulkActionService;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    private $bulkActionService;

    public function __construct(BulkActionService $bulkActionService)
    {
        $this->bulkActionService = $bulkActionService;
    }

    public function updatePengaduanStatus(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'status' => 'required|in:baru,diproses,selesai,ditolak',
        ]);

        $count = $this->bulkActionService->updatePengaduanStatus($validated['ids'], $validated['status']);
        return back()->with('success', "$count pengaduan berhasil diperbarui");
    }

    public function deletePengaduan(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
        ]);

        $count = $this->bulkActionService->deletePengaduan($validated['ids']);
        return back()->with('success', "$count pengaduan berhasil dihapus");
    }

    public function approvePenerimaBansos(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
        ]);

        $count = $this->bulkActionService->approvePenerimaBansos($validated['ids']);
        return back()->with('success', "$count penerima berhasil disetujui");
    }

    public function rejectPenerimaBansos(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'alasan' => 'required|string',
        ]);

        $count = $this->bulkActionService->rejectPenerimaBansos($validated['ids'], $validated['alasan']);
        return back()->with('success', "$count penerima berhasil ditolak");
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:pengaduan,penerima_bansos',
            'ids' => 'required|array|min:1',
            'format' => 'required|in:csv',
        ]);

        if ($validated['type'] === 'pengaduan') {
            return $this->bulkActionService->exportPengaduanCsv($validated['ids']);
        } else {
            return $this->bulkActionService->exportPenerimaBansosCsv($validated['ids']);
        }
    }
}
