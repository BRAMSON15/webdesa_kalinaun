<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Mail;

class KadesController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pengajuan' => PengajuanSurat::count(),
            'pengajuan_pending' => PengajuanSurat::where('status', 'diproses')->count(),
            'pengajuan_disetujui' => PengajuanSurat::where('status', 'disetujui')->count(),
            'pengajuan_ditolak' => PengajuanSurat::where('status', 'ditolak')->count(),
            'bansos_pending' => PenerimaBansos::where('status', 'menunggu')->count(),
        ];

        $pengajuanTerbaru = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', 'diproses')
            ->latest()
            ->take(5)
            ->get();

        $bansosTerbaru = PenerimaBansos::with(['user', 'bansos'])
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        return view('kades.dashboard', compact('stats', 'pengajuanTerbaru', 'bansosTerbaru'));
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

        auth()->user()->update($request->only(['name', 'email', 'alamat', 'no_hp']));

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }

    public function validasiPengajuan()
    {
        $pengajuans = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', 'diproses')
            ->latest()
            ->get();

        return view('kades.validasi-pengajuan', compact('pengajuans'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = PengajuanSurat::with(['user', 'jenisSurat'])->findOrFail($id);
        return view('kades.detail-pengajuan', compact('pengajuan'));
    }

    public function prosesPengajuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_kades' => 'nullable|string',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        
        $pengajuan->update([
            'status' => $request->status,
            'catatan_kades' => $request->catatan_kades,
            'diproses_oleh' => auth()->id(),
            $request->status === 'disetujui' ? 'tanggal_disetujui' : 'tanggal_ditolak' => now(),
        ]);

        // Generate nomor surat jika disetujui
        if ($request->status === 'disetujui') {
            $nomorSurat = $this->generateNomorSurat($pengajuan);
            $pengajuan->update(['nomor_surat' => $nomorSurat]);
        }

        // Kirim notifikasi email (implementasi sederhana)
        $this->kirimNotifikasiEmail($pengajuan);

        return redirect()->route('kades.validasi-pengajuan')
            ->with('success', 'Pengajuan berhasil ' . $request->status);
    }

    public function validasiBansos()
    {
        $penerimas = PenerimaBansos::with(['user', 'bansos'])
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('kades.validasi-bansos', compact('penerimas'));
    }

    public function approveBansos(Request $request, Bansos $bansos, PenerimaBansos $penerima)
    {
        $oldStatus = $penerima->status;
        
        // Cek kuota
        if ($bansos->kuota_terpakai >= $bansos->kuota) {
            return back()->with('error', 'Kuota program bansos ini sudah penuh');
        }

        $penerima->update([
            'status' => 'disetujui',
            'alasan_penolakan' => null,
            'catatan' => $request->input('catatan', 'Disetujui oleh Kepala Desa'),
        ]);

        // Update kuota terpakai
        $bansos->increment('kuota_terpakai');

        // Send notification
        try {
            NotificationService::notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan bansos berhasil disetujui');
    }

    public function rejectBansos(Request $request, Bansos $bansos, PenerimaBansos $penerima)
    {
        $oldStatus = $penerima->status;
        
        $validated = $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $penerima->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $validated['alasan_penolakan'],
            'catatan' => 'Ditolak oleh Kepala Desa',
        ]);

        // Send notification
        try {
            NotificationService::notifyBansosStatusChange($penerima, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan bansos berhasil ditolak');
    }

    public function monitoringPengaduan()
    {
        $pengajuans = PengajuanSurat::with(['user', 'jenisSurat'])
            ->latest()
            ->paginate(10);

        return view('kades.monitoring-pengaduan', compact('pengajuans'));
    }

    public function laporanArsip(Request $request)
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', '!=', 'diproses');

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->latest()->get();

        return view('kades.laporan-arsip', compact('pengajuans'));
    }

    private function generateNomorSurat($pengajuan)
    {
        $tahun = date('Y');
        $bulan = date('m');
        
        // Format: 001/JENIS/DESA/MM/YYYY
        $counter = PengajuanSurat::where('status', 'disetujui')
            ->whereYear('tanggal_disetujui', $tahun)
            ->whereMonth('tanggal_disetujui', $bulan)
            ->count();
        
        $nomorUrut = str_pad($counter + 1, 3, '0', STR_PAD_LEFT);
        $jenisCode = strtoupper(substr($pengajuan->jenisSurat->nama_surat, 0, 3));
        
        return "{$nomorUrut}/{$jenisCode}/DESA/{$bulan}/{$tahun}";
    }

    private function kirimNotifikasiEmail($pengajuan)
    {
        // Implementasi sederhana notifikasi email
        // Dalam implementasi nyata, gunakan Mail facade dengan template email
        try {
            // Mail::to($pengajuan->user->email)->send(new PengajuanStatusMail($pengajuan));
        } catch (\Exception $e) {
            // Log error jika gagal kirim email
        }
    }
}
