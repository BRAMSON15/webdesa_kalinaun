<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class BansosController extends Controller
{
    /**
     * Display a listing of active bansos programs
     */
    public function index()
    {
        $bansos = Bansos::aktif()->withQuota()->paginate(10);
        return view('masyarakat.bansos.index', compact('bansos'));
    }

    /**
     * Display the specified bansos program
     */
    public function show(Bansos $bansos)
    {
        // Check if user already applied
        $sudahMendaftar = PenerimaBansos::where('bansos_id', $bansos->id)
            ->where('user_id', auth()->id())
            ->exists();

        return view('masyarakat.bansos.show', compact('bansos', 'sudahMendaftar'));
    }

    /**
     * Apply for bansos program
     */
    public function apply(Request $request, Bansos $bansos)
    {
        // Check if bansos still has quota
        if (!$bansos->hasQuota()) {
            return back()->with('error', 'Kuota program bansos sudah habis');
        }

        // Check if user already applied
        $existing = PenerimaBansos::where('bansos_id', $bansos->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mendaftar untuk program ini');
        }

        $user = auth()->user();

        // Create application
        $penerima = PenerimaBansos::create([
            'bansos_id' => $bansos->id,
            'user_id' => auth()->id(),
            'nik' => $user->nik,
            'nama_penerima' => $user->name,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
            'status' => 'menunggu',
        ]);

        // Send notification (with error handling)
        try {
            NotificationService::notifyNewBansosApplication($penerima);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return redirect()->route('masyarakat.bansos.show', $bansos)
            ->with('success', 'Pendaftaran berhasil. Silakan tunggu verifikasi dari admin.');
    }

    /**
     * Display user's bansos applications
     */
    public function myApplications()
    {
        $applications = PenerimaBansos::where('user_id', auth()->id())
            ->with('bansos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('masyarakat.bansos.applications', compact('applications'));
    }

    /**
     * Display detail of user's application
     */
    public function applicationDetail(PenerimaBansos $penerima)
    {
        // Ensure user can only view their own applications
        if ($penerima->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $penerima->load('bansos');
        return view('masyarakat.bansos.application-detail', compact('penerima'));
    }

    /**
     * Cancel application
     */
    public function cancelApplication(PenerimaBansos $penerima)
    {
        // Only allow cancellation if status is 'menunggu'
        if ($penerima->user_id !== auth()->id() || $penerima->status !== 'menunggu') {
            abort(403, 'Unauthorized');
        }

        $penerima->delete();

        return redirect()->route('masyarakat.bansos.applications')
            ->with('success', 'Pendaftaran berhasil dibatalkan');
    }
}
