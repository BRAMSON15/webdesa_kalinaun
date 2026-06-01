<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Services\BansosApplicationService;
use App\Services\NotificationService;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;

class BansosController extends Controller
{
    private $bansosApplicationService;

    public function __construct(BansosApplicationService $bansosApplicationService)
    {
        $this->bansosApplicationService = $bansosApplicationService;
    }

    public function index()
    {
        $bansos = $this->bansosApplicationService->getActiveBansos();
        return view('masyarakat.bansos.index', compact('bansos'));
    }

    public function show(Bansos $bansos)
    {
        $sudahMendaftar = $this->bansosApplicationService->hasUserApplied(auth()->id(), $bansos->id);
        return view('masyarakat.bansos.show', compact('bansos', 'sudahMendaftar'));
    }

    public function apply(Request $request, Bansos $bansos)
    {
        try {
            $penerima = $this->bansosApplicationService->applyBansos(auth()->user(), $bansos);

            try {
                NotificationService::notifyNewBansosApplication($penerima);
            } catch (\Exception $e) {
                \Log::error('Notification error: ' . $e->getMessage());
            }

            return redirect()->route('masyarakat.bansos.show', $bansos)
                ->with('success', 'Pendaftaran berhasil. Silakan tunggu verifikasi dari admin.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function myApplications()
    {
        $applications = $this->bansosApplicationService->getUserApplications(auth()->id());
        return view('masyarakat.bansos.applications', compact('applications'));
    }

    public function applicationDetail(PenerimaBansos $penerima)
    {
        try {
            $penerima = $this->bansosApplicationService->getApplicationDetail(auth()->id(), $penerima);
            return view('masyarakat.bansos.application-detail', compact('penerima'));
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function cancelApplication(PenerimaBansos $penerima)
    {
        try {
            $this->bansosApplicationService->cancelApplication(auth()->id(), $penerima);
            return redirect()->route('masyarakat.bansos.applications')
                ->with('success', 'Pendaftaran berhasil dibatalkan');
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }
}
