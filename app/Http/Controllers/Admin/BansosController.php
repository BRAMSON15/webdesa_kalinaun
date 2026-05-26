<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;

class BansosController extends Controller
{
    /**
     * Display a listing of bansos programs
     */
    public function index(Request $request)
    {
        $query = Bansos::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by nama
        if ($request->filled('search')) {
            $query->where('nama_bansos', 'like', "%{$request->search}%");
        }

        $bansos = $query->orderBy('tanggal_mulai', 'desc')->paginate(15);

        return view('admin.bansos.index', compact('bansos'));
    }

    /**
     * Show the form for creating a new bansos program
     */
    public function create()
    {
        return view('admin.bansos.create');
    }

    /**
     * Store a newly created bansos program in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bansos' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat_ketentuan' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif,selesai',
            'nominal' => 'nullable|numeric|min:0',
            'jenis_bansos' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        Bansos::create($validated);

        return redirect()->route('admin.bansos.index')
            ->with('success', 'Program bansos berhasil ditambahkan');
    }

    /**
     * Display the specified bansos program
     */
    public function show(Bansos $bansos)
    {
        $bansos->load('penerima.user');
        $statistik = [
            'total_penerima' => $bansos->penerima()->count(),
            'disetujui' => $bansos->penerimaDisetujui()->count(),
            'ditolak' => $bansos->penerima()->where('status', 'ditolak')->count(),
            'menunggu' => $bansos->penerima()->where('status', 'menunggu')->count(),
        ];

        return view('admin.bansos.show', compact('bansos', 'statistik'));
    }

    /**
     * Show the form for editing the specified bansos program
     */
    public function edit(Bansos $bansos)
    {
        return view('admin.bansos.edit', compact('bansos'));
    }

    /**
     * Update the specified bansos program in storage
     */
    public function update(Request $request, Bansos $bansos)
    {
        $validated = $request->validate([
            'nama_bansos' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat_ketentuan' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif,selesai',
            'nominal' => 'nullable|numeric|min:0',
            'jenis_bansos' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $bansos->update($validated);

        return redirect()->route('admin.bansos.show', $bansos)
            ->with('success', 'Program bansos berhasil diperbarui');
    }

    /**
     * Remove the specified bansos program from storage
     */
    public function destroy(Bansos $bansos)
    {
        $bansos->delete();

        return redirect()->route('admin.bansos.index')
            ->with('success', 'Program bansos berhasil dihapus');
    }

    /**
     * Manage recipients for a bansos program
     */
    public function managePenerima(Bansos $bansos)
    {
        $penerima = $bansos->penerima()->with('user')->paginate(15);
        return view('admin.bansos.penerima', compact('bansos', 'penerima'));
    }

    /**
     * Approve a recipient
     */
    public function approvePenerima(Request $request, Bansos $bansos, PenerimaBansos $penerima)
    {
        $oldStatus = $penerima->status;

        if (!$bansos->hasQuota()) {
            return back()->with('error', 'Kuota program bansos sudah habis');
        }

        $penerima->update([
            'status' => 'disetujui',
            'tanggal_penerimaan' => now(),
            'nominal_diterima' => $bansos->nominal,
        ]);

        // Update kuota terpakai
        $bansos->increment('kuota_terpakai');

        // Send notification (with error handling)
        try {
            NotificationService::notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return back()->with('success', 'Penerima berhasil disetujui');
    }

    /**
     * Reject a recipient
     */
    public function rejectPenerima(Request $request, Bansos $bansos, PenerimaBansos $penerima)
    {
        $oldStatus = $penerima->status;
        
        $validated = $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $penerima->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $validated['alasan_penolakan'],
        ]);

        // Send notification (with error handling)
        try {
            NotificationService::notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return back()->with('success', 'Penerima berhasil ditolak');
    }
}
