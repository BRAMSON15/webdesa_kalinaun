<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of complaints
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with('user', 'admin');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search by judul or deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')->paginate(15);

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new complaint
     */
    public function create()
    {
        // Admin tidak perlu membuat pengaduan
        return redirect()->route('admin.pengaduan.index');
    }

    /**
     * Store a newly created complaint in storage
     */
    public function store(Request $request)
    {
        // Admin tidak perlu membuat pengaduan
        return redirect()->route('admin.pengaduan.index');
    }

    /**
     * Display the specified complaint
     */
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('user', 'admin');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified complaint
     */
    public function edit(Pengaduan $pengaduan)
    {
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified complaint in storage
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $oldStatus = $pengaduan->status;
        
        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $validated['admin_id'] = auth('admin')->id();
        
        if ($request->status === 'selesai' || $request->status === 'ditolak') {
            $validated['tanggal_selesai'] = now();
        }

        $pengaduan->update($validated);

        // Send notification if status changed
        if ($oldStatus !== $pengaduan->status) {
            NotificationService::notifyComplaintStatusChange($pengaduan, $oldStatus);
        }

        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui');
    }

    /**
     * Remove the specified complaint from storage
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        return [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];
    }
}
