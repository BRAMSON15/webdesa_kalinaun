<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search pengaduan
     */
    public function searchPengaduan(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('from_date')) {
            $query->where('tanggal_pengaduan', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('tanggal_pengaduan', '<=', $request->to_date);
        }

        $results = $query->orderBy('tanggal_pengaduan', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    /**
     * Search penerima bansos
     */
    public function searchPenerimaBansos(Request $request)
    {
        $query = PenerimaBansos::with('user', 'bansos');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_penerima', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bansos_id')) {
            $query->where('bansos_id', $request->bansos_id);
        }

        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $results = $query->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    /**
     * Search pengajuan surat
     */
    public function searchPengajuanSurat(Request $request)
    {
        $query = PengajuanSurat::with('user', 'jenisSurat');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('keperluan', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $results = $query->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results,
        ]);
    }

    /**
     * Get filter options
     */
    public function getFilterOptions(Request $request)
    {
        $type = $request->get('type', 'pengaduan');

        $options = [];

        if ($type === 'pengaduan') {
            $options['statuses'] = ['baru', 'diproses', 'selesai', 'ditolak'];
            $options['categories'] = Pengaduan::distinct('kategori')->pluck('kategori');
        } elseif ($type === 'penerima_bansos') {
            $options['statuses'] = ['menunggu', 'disetujui', 'ditolak'];
            $options['programs'] = Bansos::select('id', 'nama_bansos')->get();
        } elseif ($type === 'pengajuan_surat') {
            $options['statuses'] = ['proses', 'disetujui', 'ditolak'];
            $options['jenis_surat'] = PengajuanSurat::with('jenisSurat')->distinct('jenis_surat_id')->get();
        }

        return response()->json([
            'success' => true,
            'options' => $options,
        ]);
    }
}
