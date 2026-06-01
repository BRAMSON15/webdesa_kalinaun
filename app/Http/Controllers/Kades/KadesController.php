<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Services\KadesService;
use Illuminate\Http\Request;

class KadesController extends Controller
{
    protected $kadesService;

    public function __construct(KadesService $kadesService)
    {
        $this->kadesService = $kadesService;
    }

    public function dashboard()
    {
        $stats = $this->kadesService->getDashboardStats();
        $data = $this->kadesService->getRecentData();

        return view('kades.dashboard', array_merge(
            compact('stats'),
            $data
        ));
    }

    public function profilSekdes()
    {
        $user = auth()->user();
        return view('kades.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
        ]);

        $this->kadesService->updateProfile(auth()->user(), $request->only(['name', 'email', 'alamat', 'no_hp']));

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }

    public function validasiPengajuan()
    {
        $pengajuans = $this->kadesService->getPengajuanForValidasi();
        return view('kades.validasi-pengajuan', compact('pengajuans'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = $this->kadesService->getDetailPengajuan($id);
        return view('kades.detail-pengajuan', compact('pengajuan'));
    }

    public function prosesPengajuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_kades' => 'nullable|string',
        ]);

        $this->kadesService->processPengajuan($id, $request->status, $request->catatan_kades, auth()->id());

        return redirect()->route('kades.validasi-pengajuan')
            ->with('success', 'Pengajuan berhasil ' . $request->status);
    }

    public function validasiBansos()
    {
        $penerimas = $this->kadesService->getBansosForValidasi();
        return view('kades.validasi-bansos', compact('penerimas'));
    }

    public function approveBansos(Request $request, $bansosId, $penerimaId)
    {
        try {
            $this->kadesService->approveBansos($bansosId, $penerimaId, $request->input('catatan'));
            return back()->with('success', 'Permohonan bansos berhasil disetujui');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rejectBansos(Request $request, $bansosId, $penerimaId)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        try {
            $this->kadesService->rejectBansos($bansosId, $penerimaId, $request->alasan_penolakan);
            return back()->with('success', 'Permohonan bansos berhasil ditolak');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function monitoringPengaduan(Request $request)
    {
        $pengajuans = $this->kadesService->getMonitoringPengaduan($request->get('page', 1));
        return view('kades.monitoring-pengaduan', compact('pengajuans'));
    }

    public function laporanArsip(Request $request)
    {
        $filters = [
            'bulan' => $request->get('bulan'),
            'tahun' => $request->get('tahun'),
            'status' => $request->get('status'),
        ];

        $pengajuans = $this->kadesService->getLaporanArsip($filters);
        return view('kades.laporan-arsip', compact('pengajuans'));
    }
}
