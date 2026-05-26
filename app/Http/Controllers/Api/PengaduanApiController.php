<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanApiController extends Controller
{
    /**
     * Get all complaints for authenticated user
     */
    public function index(Request $request)
    {
        $query = Pengaduan::where('user_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $pengaduans,
        ]);
    }

    /**
     * Get single complaint
     */
    public function show(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $pengaduan->load('user', 'admin'),
        ]);
    }

    /**
     * Create new complaint
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

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dibuat',
            'data' => $pengaduan,
        ], 201);
    }

    /**
     * Update complaint
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'baru') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|in:layanan,infrastruktur,kesehatan,pendidikan,lainnya',
        ]);

        $pengaduan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diperbarui',
            'data' => $pengaduan,
        ]);
    }

    /**
     * Delete complaint
     */
    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'baru') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $pengaduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dihapus',
        ]);
    }

    /**
     * Get complaint statistics
     */
    public function statistics()
    {
        $userId = auth()->id();

        $stats = [
            'total' => Pengaduan::where('user_id', $userId)->count(),
            'baru' => Pengaduan::where('user_id', $userId)->where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
