<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Services\PengaduanService;
use App\Services\NotificationService;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    private $pengaduanService;

    public function __construct(PengaduanService $pengaduanService)
    {
        $this->pengaduanService = $pengaduanService;
    }

    public function index(Request $request)
    {
        $pengaduans = $this->pengaduanService->getUserComplaints(auth()->id(), $request->all());
        return view('masyarakat.pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('masyarakat.pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|in:layanan,infrastruktur,kesehatan,pendidikan,lainnya',
        ]);

        $pengaduan = $this->pengaduanService->createComplaint(auth()->id(), $validated);

        try {
            NotificationService::notifyNewComplaint($pengaduan);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return redirect()->route('masyarakat.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim. Terima kasih atas masukan Anda.');
    }

    public function show(Pengaduan $pengaduan)
    {
        try {
            $pengaduan = $this->pengaduanService->getComplaintDetail(auth()->id(), $pengaduan->id);
            return view('masyarakat.pengaduan.show', compact('pengaduan'));
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function edit(Pengaduan $pengaduan)
    {
        try {
            $pengaduan = $this->pengaduanService->getComplaintDetail(auth()->id(), $pengaduan->id);
            if ($pengaduan->status !== 'baru') {
                abort(403, 'Unauthorized');
            }
            return view('masyarakat.pengaduan.edit', compact('pengaduan'));
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|in:layanan,infrastruktur,kesehatan,pendidikan,lainnya',
        ]);

        try {
            $this->pengaduanService->updateComplaint(auth()->id(), $pengaduan, $validated);
            return redirect()->route('masyarakat.pengaduan.show', $pengaduan)
                ->with('success', 'Pengaduan berhasil diperbarui');
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function destroy(Pengaduan $pengaduan)
    {
        try {
            $this->pengaduanService->deleteComplaint(auth()->id(), $pengaduan);
            return redirect()->route('masyarakat.pengaduan.index')
                ->with('success', 'Pengaduan berhasil dihapus');
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }
}
