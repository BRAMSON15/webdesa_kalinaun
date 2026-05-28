<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\ProfilDesa;
use App\Models\InformasiDesa;
use App\Models\ArsipDokumen;
use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_pengajuan' => PengajuanSurat::count(),
            'pengajuan_pending' => PengajuanSurat::where('status', 'diproses')->count(),
            'total_informasi' => InformasiDesa::count(),
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_baru' => Pengaduan::where('status', 'baru')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            'total_bansos' => Bansos::count(),
            'bansos_aktif' => Bansos::where('status', 'aktif')->count(),
            'total_penerima_bansos' => PenerimaBansos::count(),
            'penerima_disetujui' => PenerimaBansos::where('status', 'disetujui')->count(),
        ];

        $pengajuanTerbaru = PengajuanSurat::with(['user', 'jenisSurat'])->latest()->take(5)->get();
        $pengaduanTerbaru = Pengaduan::with('user')->latest()->take(5)->get();
        $bansosAktif = Bansos::where('status', 'aktif')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pengajuanTerbaru', 'pengaduanTerbaru', 'bansosAktif'));
    }

    // Kelola Profil Desa
    public function profilDesa()
    {
        $profil = ProfilDesa::first();
        return view('admin.profil-desa', compact('profil'));
    }

    public function updateProfilDesa(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string',
            'nama_kepala_desa' => 'required|string',
            'alamat_desa' => 'required|string',
            'kode_pos' => 'required|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
        ]);

        $profil = ProfilDesa::first();
        if ($profil) {
            $profil->update($request->all());
        } else {
            ProfilDesa::create($request->all());
        }

        return redirect()->back()->with('success', 'Profil desa berhasil diupdate');
    }

    // Kelola Status Pengajuan Surat
    public function pengajuanSurat()
    {
        $pengajuans = PengajuanSurat::with(['user', 'jenisSurat'])->latest()->get();
        return view('admin.pengajuan-surat', compact('pengajuans'));
    }

    // Kelola Informasi Desa
    public function informasiDesa()
    {
        $informasis = InformasiDesa::with('creator')->latest()->get();
        return view('admin.informasi-desa.index', compact('informasis'));
    }

    public function createInformasi()
    {
        return view('admin.informasi-desa.create');
    }

    public function storeInformasi(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'kategori' => 'required|in:berita,pengumuman,kegiatan,lainnya',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('informasi', 'public');
        }

        InformasiDesa::create($data);

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil ditambahkan');
    }

    public function showInformasi($id)
    {
        $informasi = InformasiDesa::with('creator')->findOrFail($id);
        return view('admin.informasi-desa.show', compact('informasi'));
    }

    public function editInformasi($id)
    {
        $informasi = InformasiDesa::findOrFail($id);
        return view('admin.informasi-desa.edit', compact('informasi'));
    }

    public function updateInformasi(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'kategori' => 'required|in:berita,pengumuman,kegiatan,lainnya',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $informasi = InformasiDesa::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($informasi->gambar) {
                \Storage::disk('public')->delete($informasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('informasi', 'public');
        }

        $informasi->update($data);

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil diperbarui');
    }

    public function destroyInformasi($id)
    {
        $informasi = InformasiDesa::findOrFail($id);
        
        // Delete image if exists
        if ($informasi->gambar) {
            \Storage::disk('public')->delete($informasi->gambar);
        }
        
        $informasi->delete();

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil dihapus');
    }

    // Kelola Data Pengguna
    public function dataPengguna()
    {
        $users = User::latest()->get();
        return view('admin.data-pengguna', compact('users'));
    }

    public function updatePengguna(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_hp' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:100',
            'role' => 'nullable|in:masyarakat,kades',
        ]);

        $user = User::findOrFail($id);
        
        // Don't allow changing admin role
        if ($user->role === 'admin') {
            return response()->json(['error' => 'Cannot modify admin user'], 403);
        }

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diperbarui',
            'user' => $user
        ]);
    }

    // Kelola Jenis Surat
    public function jenisSurat()
    {
        $jenisSurats = JenisSurat::latest()->get();
        return view('admin.jenis-surat.index', compact('jenisSurats'));
    }

    public function createJenisSurat()
    {
        return view('admin.jenis-surat.create');
    }

    public function storeJenisSurat(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|array',
        ]);

        JenisSurat::create($request->all());

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil ditambahkan');
    }

    public function showJenisSurat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        return view('admin.jenis-surat.show', compact('jenisSurat'));
    }

    public function editJenisSurat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        return view('admin.jenis-surat.edit', compact('jenisSurat'));
    }

    public function updateJenisSurat(Request $request, $id)
    {
        $request->validate([
            'nama_surat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->update($request->all());

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil diperbarui');
    }

    public function destroyJenisSurat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil dihapus');
    }

    // Mencetak Surat
    public function cetakSurat($id)
    {
        $pengajuan = PengajuanSurat::with(['user', 'jenisSurat'])->findOrFail($id);
        
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui');
        }

        return view('admin.cetak-surat', compact('pengajuan'));
    }

    // Kelola Arsip Dokumen
    public function arsipDokumen()
    {
        $arsips = ArsipDokumen::with('uploader')->latest()->get();
        return view('admin.arsip-dokumen.index', compact('arsips'));
    }

    public function createArsip()
    {
        return view('admin.arsip-dokumen.create');
    }

    public function storeArsip(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:surat_masuk,surat_keluar,sk,perdes,lainnya',
            'tanggal_dokumen' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('arsip', 'public');

        ArsipDokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'kategori' => $request->kategori,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.arsip-dokumen')->with('success', 'Dokumen berhasil diarsipkan');
    }
}
