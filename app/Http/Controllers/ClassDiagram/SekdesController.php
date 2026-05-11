<?php

namespace App\Http\Controllers\ClassDiagram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblSekdes;
use App\Models\TblPengajuanSurat;
use Illuminate\Support\Facades\Auth;

class SekdesController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pengajuan' => TblPengajuanSurat::count(),
            'pengajuan_proses' => TblPengajuanSurat::byStatus('proses')->count(),
            'pengajuan_selesai' => TblPengajuanSurat::byStatus('selesai')->count(),
            'pengajuan_ditolak' => TblPengajuanSurat::byStatus('ditolak')->count(),
        ];

        $pengajuanMenunggu = TblPengajuanSurat::with('masyarakat')
            ->byStatus('proses')
            ->latest('tgl_pengajuan')
            ->take(5)
            ->get();

        return view('class-diagram.sekdes.dashboard', compact('stats', 'pengajuanMenunggu'));
    }

    public function daftarPengajuan()
    {
        $pengajuans = TblPengajuanSurat::with('masyarakat')
            ->byStatus('proses')
            ->orderBy('tgl_pengajuan', 'asc')
            ->paginate(10);

        return view('class-diagram.sekdes.daftar-pengajuan', compact('pengajuans'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = TblPengajuanSurat::with('masyarakat')->findOrFail($id);
        
        return view('class-diagram.sekdes.detail-pengajuan', compact('pengajuan'));
    }

    public function validasiAkhir(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $sekdes = Auth::guard('sekdes')->user();
        
        $result = $sekdes->validasiAkhir(
            $id, 
            $request->status, 
            $request->catatan
        );

        if ($result) {
            $statusText = $request->status === 'selesai' ? 'disetujui' : 'ditolak';
            return redirect()->route('class-diagram.sekdes.daftar-pengajuan')
                ->with('success', "Pengajuan berhasil {$statusText}.");
        }

        return back()->withErrors(['error' => 'Gagal memproses validasi.']);
    }

    public function laporanArsip()
    {
        $sekdes = Auth::guard('sekdes')->user();
        $laporanArsip = $sekdes->lihatLaporanArsip();

        return view('class-diagram.sekdes.laporan-arsip', compact('laporanArsip'));
    }

    public function exportLaporan(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|between:1,12',
            'tahun' => 'nullable|integer|min:2020',
            'status' => 'nullable|in:selesai,ditolak'
        ]);

        $sekdes = Auth::guard('sekdes')->user();
        $laporan = $sekdes->lihatLaporanArsip();

        // Filter berdasarkan parameter
        if ($request->bulan) {
            $laporan = $laporan->filter(function ($item) use ($request) {
                return $item->tgl_pengajuan->month == $request->bulan;
            });
        }

        if ($request->tahun) {
            $laporan = $laporan->filter(function ($item) use ($request) {
                return $item->tgl_pengajuan->year == $request->tahun;
            });
        }

        if ($request->status) {
            $laporan = $laporan->filter(function ($item) use ($request) {
                return $item->status == $request->status;
            });
        }

        return view('class-diagram.sekdes.export-laporan', compact('laporan'));
    }

    public function profil()
    {
        $user = Auth::guard('sekdes')->user();
        return view('class-diagram.sekdes.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:tbl_sekdes,username,' . Auth::guard('sekdes')->id() . ',id_sekdes',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user = Auth::guard('sekdes')->user();
        
        $updateData = ['username' => $request->username];
        
        if ($request->password) {
            $updateData['password'] = bcrypt($request->password);
        }
        
        $user->update($updateData);

        return redirect()->back()->with('success', 'Profil berhasil diupdate.');
    }
}
