<?php

namespace App\Http\Controllers\ClassDiagram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblMasyarakat;
use App\Models\TblPengajuanSurat;
use Illuminate\Support\Facades\Auth;

class MasyarakatController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('masyarakat')->user();
        
        $stats = [
            'total_pengajuan' => $user->pengajuanSurat()->count(),
            'pengajuan_proses' => $user->pengajuanSurat()->byStatus('proses')->count(),
            'pengajuan_selesai' => $user->pengajuanSurat()->byStatus('selesai')->count(),
            'pengajuan_ditolak' => $user->pengajuanSurat()->byStatus('ditolak')->count(),
        ];

        $pengajuanTerbaru = $user->pengajuanSurat()
            ->latest('tgl_pengajuan')
            ->take(5)
            ->get();

        return view('class-diagram.masyarakat.dashboard', compact('stats', 'pengajuanTerbaru'));
    }

    public function formPengajuan()
    {
        $jenisSurat = [
            'Surat Keterangan Domisili',
            'Surat Keterangan Usaha',
            'Surat Keterangan Tidak Mampu',
            'Surat Pengantar Nikah',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian'
        ];

        return view('class-diagram.masyarakat.form-pengajuan', compact('jenisSurat'));
    }

    public function buatPengajuan(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string|max:50',
            'keterangan' => 'required|string'
        ]);

        $user = Auth::guard('masyarakat')->user();
        
        $pengajuan = $user->buatPengajuan([
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan
        ]);

        if ($pengajuan) {
            return redirect()->route('class-diagram.masyarakat.riwayat-pengajuan')
                ->with('success', 'Pengajuan surat berhasil disubmit. Silakan tunggu proses verifikasi.');
        }

        return back()->withErrors(['error' => 'Gagal membuat pengajuan. Silakan coba lagi.']);
    }

    public function riwayatPengajuan()
    {
        $user = Auth::guard('masyarakat')->user();
        
        $pengajuans = $user->pengajuanSurat()
            ->orderBy('tgl_pengajuan', 'desc')
            ->paginate(10);

        return view('class-diagram.masyarakat.riwayat-pengajuan', compact('pengajuans'));
    }

    public function cekStatus($id)
    {
        $user = Auth::guard('masyarakat')->user();
        
        $pengajuan = $user->pengajuanSurat()->find($id);
        
        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');
        }

        $statusDetail = $pengajuan->cekStatus();

        return view('class-diagram.masyarakat.detail-status', compact('statusDetail', 'pengajuan'));
    }

    public function profil()
    {
        $user = Auth::guard('masyarakat')->user();
        return view('class-diagram.masyarakat.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:tbl_masyarakat,email,' . Auth::guard('masyarakat')->id() . ',id_masyarakat',
            'no_hp' => 'required|string|max:15'
        ]);

        $user = Auth::guard('masyarakat')->user();
        $user->update($request->only(['nama', 'email', 'no_hp']));

        return redirect()->back()->with('success', 'Profil berhasil diupdate.');
    }
}
