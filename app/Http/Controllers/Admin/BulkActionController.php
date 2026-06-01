<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    /**
     * Bulk update pengaduan status
     */
    public function updatePengaduanStatus(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:pengaduans,id',
            'status' => 'required|in:baru,diproses,selesai,ditolak',
        ]);

        $count = Pengaduan::whereIn('id', $validated['ids'])
            ->update(['status' => $validated['status']]);

        return back()->with('success', "$count pengaduan berhasil diperbarui");
    }

    /**
     * Bulk delete pengaduan
     */
    public function deletePengaduan(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:pengaduans,id',
        ]);

        $count = Pengaduan::whereIn('id', $validated['ids'])->delete();

        return back()->with('success', "$count pengaduan berhasil dihapus");
    }

    /**
     * Bulk approve penerima bansos
     */
    public function approvePenerimaBansos(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:penerima_bansos,id',
        ]);

        $penerimas = PenerimaBansos::whereIn('id', $validated['ids'])->get();
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

        return back()->with('success', "$count penerima berhasil disetujui");
    }

    /**
     * Bulk reject penerima bansos
     */
    public function rejectPenerimaBansos(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:penerima_bansos,id',
            'alasan' => 'required|string',
        ]);

        $count = PenerimaBansos::whereIn('id', $validated['ids'])
            ->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $validated['alasan'],
            ]);

        return back()->with('success', "$count penerima berhasil ditolak");
    }

    /**
     * Export selected data
     */
    public function export(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:pengaduan,penerima_bansos',
            'ids' => 'required|array|min:1',
            'format' => 'required|in:csv,pdf',
        ]);

        if ($validated['type'] === 'pengaduan') {
            $data = Pengaduan::whereIn('id', $validated['ids'])->get();
            return $this->exportPengaduan($data, $validated['format']);
        } else {
            $data = PenerimaBansos::whereIn('id', $validated['ids'])->with('user', 'bansos')->get();
            return $this->exportPenerimaBansos($data, $validated['format']);
        }
    }

    private function exportPengaduan($data, $format)
    {
        if ($format === 'csv') {
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
    }

    private function exportPenerimaBansos($data, $format)
    {
        if ($format === 'csv') {
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
}
