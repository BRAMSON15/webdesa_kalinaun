<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of user's complaints
     */
    public function index(Request $request)
    {
        $query = Pengaduan::where('user_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')->paginate(10);

        return view('masyarakat.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new complaint
     */
    public function create()
    {
        return view('masyarakat.pengaduan.create');
    }

    /**
     * Store a newly created complaint in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|in:layanan,infrastruktur,kesehatan,pendidikan,lainnya',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'baru';
        $validated['tanggal_pengaduan'] = now();

        $pengaduan = Pengaduan::create($validated);

        // Send notification
        NotificationService::notifyNewComplaint($pengaduan);

        return redirect()->route('masyarakat.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim. Terima kasih atas masukan Anda.');
    }

    /**
     * Display the specified complaint
     */
    public function show(Pengaduan $pengaduan)
    {
        // Ensure user can only view their own complaints
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('masyarakat.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified complaint
     */
    public function edit(Pengaduan $pengaduan)
    {
        // Only allow editing if status is 'baru'
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'baru') {
            abort(403, 'Unauthorized');
        }

        return view('masyarakat.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified complaint in storage
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Only allow editing if status is 'baru'
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'baru') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|in:layanan,infrastruktur,kesehatan,pendidikan,lainnya',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('masyarakat.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui');
    }

    /**
     * Remove the specified complaint from storage
     */
    public function destroy(Pengaduan $pengaduan)
    {
        // Only allow deletion if status is 'baru'
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'baru') {
            abort(403, 'Unauthorized');
        }

        $pengaduan->delete();

        return redirect()->route('masyarakat.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
