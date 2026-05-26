<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Export pengaduan to CSV
     */
    public function exportPengaduan(Request $request)
    {
        $query = Pengaduan::with('user', 'admin');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')->get();

        $filename = 'pengaduan_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://memory', 'w');

        // Header
        fputcsv($handle, [
            'ID',
            'Tanggal',
            'Judul',
            'Kategori',
            'Pelapor',
            'Status',
            'Catatan Admin',
            'Tanggal Selesai'
        ]);

        // Data
        foreach ($pengaduans as $pengaduan) {
            fputcsv($handle, [
                $pengaduan->id,
                $pengaduan->tanggal_pengaduan->format('d/m/Y H:i'),
                $pengaduan->judul,
                ucfirst($pengaduan->kategori),
                $pengaduan->user->name,
                ucfirst($pengaduan->status),
                $pengaduan->catatan_admin,
                $pengaduan->tanggal_selesai ? $pengaduan->tanggal_selesai->format('d/m/Y H:i') : '-'
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export bansos to CSV
     */
    public function exportBansos(Request $request)
    {
        $query = Bansos::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bansos = $query->orderBy('tanggal_mulai', 'desc')->get();

        $filename = 'bansos_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://memory', 'w');

        // Header
        fputcsv($handle, [
            'ID',
            'Nama Program',
            'Jenis',
            'Kuota',
            'Kuota Terpakai',
            'Nominal',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status'
        ]);

        // Data
        foreach ($bansos as $program) {
            fputcsv($handle, [
                $program->id,
                $program->nama_bansos,
                $program->jenis_bansos,
                $program->kuota,
                $program->kuota_terpakai,
                'Rp ' . number_format($program->nominal, 0, ',', '.'),
                $program->tanggal_mulai->format('d/m/Y'),
                $program->tanggal_selesai->format('d/m/Y'),
                ucfirst($program->status)
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export penerima bansos to CSV
     */
    public function exportPenerimaBansos(Request $request)
    {
        $query = PenerimaBansos::with('bansos', 'user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('bansos_id')) {
            $query->where('bansos_id', $request->bansos_id);
        }

        $penerima = $query->orderBy('created_at', 'desc')->get();

        $filename = 'penerima_bansos_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://memory', 'w');

        // Header
        fputcsv($handle, [
            'ID',
            'Program',
            'Nama Penerima',
            'NIK',
            'No. HP',
            'Alamat',
            'Status',
            'Nominal',
            'Tanggal Penerimaan'
        ]);

        // Data
        foreach ($penerima as $item) {
            fputcsv($handle, [
                $item->id,
                $item->bansos->nama_bansos,
                $item->nama_penerima,
                $item->nik,
                $item->no_hp,
                $item->alamat,
                ucfirst($item->status),
                $item->nominal_diterima ? 'Rp ' . number_format($item->nominal_diterima, 0, ',', '.') : '-',
                $item->tanggal_penerimaan ? $item->tanggal_penerimaan->format('d/m/Y') : '-'
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export pengajuan surat to CSV
     */
    public function exportPengajuanSurat(Request $request)
    {
        $query = PengajuanSurat::with('user', 'jenisSurat');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->get();

        $filename = 'pengajuan_surat_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://memory', 'w');

        // Header
        fputcsv($handle, [
            'ID',
            'Tanggal',
            'Nama Pemohon',
            'Jenis Surat',
            'Keperluan',
            'Status'
        ]);

        // Data
        foreach ($pengajuans as $pengajuan) {
            fputcsv($handle, [
                $pengajuan->id,
                $pengajuan->created_at->format('d/m/Y H:i'),
                $pengajuan->user->name,
                $pengajuan->jenisSurat->nama_surat ?? '-',
                $pengajuan->keperluan,
                ucfirst($pengajuan->status)
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
