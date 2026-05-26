<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\InformasiDesa;
use App\Models\ProfilDesa;
use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;

class MasyarakatController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_pengajuan' => $user->pengajuanSurats()->count(),
            'pengajuan_diproses' => $user->pengajuanSurats()->where('status', 'diproses')->count(),
            'pengajuan_disetujui' => $user->pengajuanSurats()->where('status', 'disetujui')->count(),
            'pengajuan_ditolak' => $user->pengajuanSurats()->where('status', 'ditolak')->count(),
            'total_pengaduan' => Pengaduan::where('user_id', $user->id)->count(),
            'pengaduan_diproses' => Pengaduan::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'bansos_aktif' => Bansos::aktif()->withQuota()->count(),
            'bansos_terdaftar' => PenerimaBansos::where('user_id', $user->id)->count(),
        ];

        $pengajuanTerbaru = $user->pengajuanSurats()
            ->with('jenisSurat')
            ->latest()
            ->take(5)
            ->get();

        $informasiTerbaru = InformasiDesa::published()
            ->latest()
            ->take(3)
            ->get();

        return view('masyarakat.dashboard', compact('stats', 'pengajuanTerbaru', 'informasiTerbaru'));
    }

    public function pengajuanSurat()
    {
        $jenisSurats = JenisSurat::active()->get();
        return view('masyarakat.pengajuan-surat.index', compact('jenisSurats'));
    }

    public function createPengajuan($jenisSuratId)
    {
        $jenisSurat = JenisSurat::findOrFail($jenisSuratId);
        return view('masyarakat.pengajuan-surat.create', compact('jenisSurat'));
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan' => 'required|string',
            'data_formulir' => 'nullable|array',
            'dokumen_pendukung.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['jenis_surat_id', 'keperluan', 'data_formulir']);
        $data['user_id'] = auth()->id();

        // Handle file uploads
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_pendukung') as $file) {
                $dokumenPaths[] = $file->store('dokumen_pendukung', 'public');
            }
            $data['dokumen_pendukung'] = $dokumenPaths;
        }

        PengajuanSurat::create($data);

        return redirect()->route('masyarakat.riwayat-pengajuan')
            ->with('success', 'Pengajuan surat berhasil disubmit');
    }

    public function riwayatPengajuan()
    {
        $pengajuans = auth()->user()->pengajuanSurats()
            ->with('jenisSurat')
            ->latest()
            ->paginate(10);

        return view('masyarakat.riwayat-pengajuan', compact('pengajuans'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = auth()->user()->pengajuanSurats()
            ->with(['jenisSurat', 'diproses'])
            ->findOrFail($id);

        return view('masyarakat.detail-pengajuan', compact('pengajuan'));
    }

    public function downloadSurat($id)
    {
        $pengajuan = auth()->user()->pengajuanSurats()->findOrFail($id);
        
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui');
        }

        // Generate PDF surat (implementasi sederhana)
        return view('masyarakat.download-surat', compact('pengajuan'));
    }

    public function informasiDesa()
    {
        $informasis = InformasiDesa::published()
            ->latest()
            ->paginate(10);

        return view('masyarakat.informasi-desa', compact('informasis'));
    }

    public function detailInformasi($id)
    {
        $informasi = InformasiDesa::published()->findOrFail($id);
        return view('masyarakat.detail-informasi', compact('informasi'));
    }

    public function profilDesa()
    {
        $profil = ProfilDesa::first();
        return view('masyarakat.profil-desa', compact('profil'));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('masyarakat.profil', compact('user'));
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
}
