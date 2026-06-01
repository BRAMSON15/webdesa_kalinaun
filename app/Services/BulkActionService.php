<?php

namespace App\Services;

use App\Models\Pengaduan;
use App\Models\PenerimaBansos;

class BulkActionService
{
    /**
     * Update pengaduan status in bulk
     */
    public function updatePengaduanStatus($ids, $status)
    {
        return Pengaduan::whereIn('id', $ids)->update(['status' => $status]);
    }

    /**
     * Delete pengaduan in bulk
     */
    public function deletePengaduan($ids)
    {
        return Pengaduan::whereIn('id', $ids)->delete();
    }

    /**
     * Approve penerima bansos in bulk
     */
    public function approvePenerimaBansos($ids)
    {
        $penerimas = PenerimaBansos::whereIn('id', $ids)->get();
        $count = 0;

        foreach ($penerimas as $penerima) {
            if ($penerima->bansos->hasQuota()) {
                $penerima->update([
                    'status' => 'disetujui',
                    'tanggal_penerimaan' => now(),
                    'nominal_diterima' => $penerima->bansos->nominal,
                ]);
                $penerima->bansos->increment('kuota_terpakai');
                $count++;
            }
        }

        return $count;
    }

    /**
     * Reject penerima bansos in bulk
     */
    public function rejectPenerimaBansos($ids, $alasan)
    {
        return PenerimaBansos::whereIn('id', $ids)->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $alasan,
        ]);
    }

    /**
     * Export pengaduan to CSV
     */
    public function exportPengaduanCsv($ids)
    {
        $data = Pengaduan::whereIn('id', $ids)->get();
        $filename = 'pengaduan_' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Judul', 'Kategori', 'Status', 'Tanggal', 'Nama Pelapor']);

            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->judul,
                    $item->kategori,
                    $item->status,
                    $item->tanggal_pengaduan->format('d/m/Y'),
                    $item->user->name,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export penerima bansos to CSV
     */
    public function exportPenerimaBansosCsv($ids)
    {
        $data = PenerimaBansos::whereIn('id', $ids)->with('user', 'bansos')->get();
        $filename = 'penerima_bansos_' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Program', 'Status', 'Nominal', 'Tanggal Daftar']);

            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->nama_penerima,
                    $item->bansos->nama_bansos,
                    $item->status,
                    $item->nominal_diterima ?? '-',
                    $item->created_at->format('d/m/Y'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
