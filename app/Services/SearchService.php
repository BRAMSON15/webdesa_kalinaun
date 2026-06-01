<?php

namespace App\Services;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;

class SearchService
{
    /**
     * Search pengaduan
     */
    public function searchPengaduan($filters = [])
    {
        $query = Pengaduan::with('user');

        if (!empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (!empty($filters['from_date'])) {
            $query->where('tanggal_pengaduan', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->where('tanggal_pengaduan', '<=', $filters['to_date']);
        }

        return $query->orderBy('tanggal_pengaduan', 'desc')->limit(50)->get();
    }

    /**
     * Search penerima bansos
     */
    public function searchPenerimaBansos($filters = [])
    {
        $query = PenerimaBansos::with('user', 'bansos');

        if (!empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_penerima', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['bansos_id'])) {
            $query->where('bansos_id', $filters['bansos_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->where('created_at', '<=', $filters['to_date']);
        }

        return $query->orderBy('created_at', 'desc')->limit(50)->get();
    }

    /**
     * Search pengajuan surat
     */
    public function searchPengajuanSurat($filters = [])
    {
        $query = PengajuanSurat::with('user', 'jenisSurat');

        if (!empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('keperluan', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['jenis_surat_id'])) {
            $query->where('jenis_surat_id', $filters['jenis_surat_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->where('created_at', '<=', $filters['to_date']);
        }

        return $query->orderBy('created_at', 'desc')->limit(50)->get();
    }

    /**
     * Get filter options
     */
    public function getFilterOptions($type = 'pengaduan')
    {
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

        return $options;
    }
}
