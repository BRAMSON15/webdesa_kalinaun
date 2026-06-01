<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function dashboard()
    {
        $stats = $this->adminService->getDashboardStats();
        $data = $this->adminService->getRecentData();

        return view('admin.dashboard', array_merge(
            compact('stats'),
            $data
        ));
    }

    // Kelola Profil Desa
    public function profilDesa()
    {
        $profil = $this->adminService->getProfilDesa();
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

        $this->adminService->updateProfilDesa($request->all());

        return redirect()->back()->with('success', 'Profil desa berhasil diupdate');
    }

    // Kelola Status Pengajuan Surat
    public function pengajuanSurat()
    {
        $pengajuans = $this->adminService->getPengajuanSurat();
        return view('admin.pengajuan-surat', compact('pengajuans'));
    }

    // Kelola Informasi Desa
    public function informasiDesa()
    {
        $informasis = $this->adminService->getInformasiDesa();
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
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar');
        }

        $this->adminService->createInformasi($data, auth()->id());

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil ditambahkan');
    }

    public function showInformasi($id)
    {
        $informasi = $this->adminService->getInformasiById($id);
        return view('admin.informasi-desa.show', compact('informasi'));
    }

    public function editInformasi($id)
    {
        $informasi = $this->adminService->getInformasiById($id);
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

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar');
        }

        $this->adminService->updateInformasi($id, $data);

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil diperbarui');
    }

    public function destroyInformasi($id)
    {
        $this->adminService->deleteInformasi($id);

        return redirect()->route('admin.informasi-desa')->with('success', 'Informasi berhasil dihapus');
    }

    // Kelola Data Pengguna
    public function dataPengguna()
    {
        $users = $this->adminService->getAllUsers();
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

        try {
            $user = $this->adminService->updateUser($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diperbarui',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        }
    }

    public function deletePengguna($id)
    {
        try {
            $this->adminService->deleteUser($id);
            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            $code = strpos($e->getMessage(), 'pengajuan aktif') !== false ? 422 : 403;
            return response()->json(['success' => false, 'message' => $e->getMessage()], $code);
        }
    }

    public function resetPasswordPengguna($id)
    {
        try {
            $tempPassword = $this->adminService->resetUserPassword($id);
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset',
                'temp_password' => $tempPassword,
                'note' => 'Berikan password sementara ini kepada pengguna. Pengguna dapat mengubahnya setelah login.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        }
    }

    // Kelola Jenis Surat
    public function jenisSurat()
    {
        $jenisSurats = $this->adminService->getJenisSurat();
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

        $this->adminService->createJenisSurat($request->all());

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil ditambahkan');
    }

    public function showJenisSurat($id)
    {
        $jenisSurat = $this->adminService->getJenisSuratById($id);
        return view('admin.jenis-surat.show', compact('jenisSurat'));
    }

    public function editJenisSurat($id)
    {
        $jenisSurat = $this->adminService->getJenisSuratById($id);
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

        $this->adminService->updateJenisSurat($id, $request->all());

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil diperbarui');
    }

    public function destroyJenisSurat($id)
    {
        $this->adminService->deleteJenisSurat($id);

        return redirect()->route('admin.jenis-surat')->with('success', 'Jenis surat berhasil dihapus');
    }

    // Mencetak Surat
    public function cetakSurat($id)
    {
        try {
            $pengajuan = $this->adminService->getPengajuanForPrint($id);
            return view('admin.cetak-surat', compact('pengajuan'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Kelola Arsip Dokumen
    public function arsipDokumen()
    {
        $arsips = $this->adminService->getArsipDokumen();
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

        $this->adminService->createArsip($request->all(), auth()->id());

        return redirect()->route('admin.arsip-dokumen')->with('success', 'Dokumen berhasil diarsipkan');
    }
}
