<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Services\MasyarakatService;
use App\Services\NotificationService;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    private $masyarakatService;

    public function __construct(MasyarakatService $masyarakatService)
    {
        $this->masyarakatService = $masyarakatService;
    }

    public function dashboard()
    {
        $user = auth()->user();
        $stats = $this->masyarakatService->getDashboardStats($user);
        $pengajuanTerbaru = $this->masyarakatService->getRecentPengajuan($user);
        $informasiTerbaru = $this->masyarakatService->getRecentInformasi();
        $jenisSurat = $this->masyarakatService->getActiveJenisSurat();

        return view('masyarakat.dashboard', compact('stats', 'pengajuanTerbaru', 'informasiTerbaru', 'jenisSurat'));
    }

    public function pengajuanSurat()
    {
        $jenisSurats = $this->masyarakatService->getActiveJenisSurat();
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

        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_pendukung') as $file) {
                $dokumenPaths[] = $file->store('dokumen_pendukung', 'public');
            }
            $data['dokumen_pendukung'] = $dokumenPaths;
        }

        $this->masyarakatService->createPengajuan(auth()->user(), $data);

        return redirect()->route('masyarakat.riwayat-pengajuan')
            ->with('success', 'Pengajuan surat berhasil disubmit');
    }

    public function riwayatPengajuan(Request $request)
    {
        $pengajuans = $this->masyarakatService->getFilteredPengajuan(auth()->user(), $request->all());
        $pengajuans->appends($request->all());

        return view('masyarakat.riwayat-pengajuan', compact('pengajuans'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = $this->masyarakatService->getPengajuanDetail(auth()->user(), $id);
        return view('masyarakat.detail-pengajuan', compact('pengajuan'));
    }

    public function downloadSurat($id)
    {
        $pengajuan = $this->masyarakatService->getPengajuanDetail(auth()->user(), $id);
        
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui');
        }

        return view('masyarakat.download-surat', compact('pengajuan'));
    }

    public function informasiDesa()
    {
        $informasis = $this->masyarakatService->getInformasiDesa();
        return view('masyarakat.informasi-desa', compact('informasis'));
    }

    public function detailInformasi($id)
    {
        $informasi = $this->masyarakatService->getInformasiDetail($id);
        return view('masyarakat.detail-informasi', compact('informasi'));
    }

    public function profilDesa()
    {
        $profil = $this->masyarakatService->getProfilDesa();
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

        $this->masyarakatService->updateProfile(auth()->user(), $request->only(['name', 'email', 'alamat', 'no_hp']));

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $this->masyarakatService->updatePassword(auth()->user(), $request->current_password, $request->password);
            return redirect()->back()->with('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['current_password' => $e->getMessage()]);
        }
    }
}
