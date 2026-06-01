<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use TCPDF;

class ExportController extends Controller
{
    /**
     * Export pengaduan to CSV
     */
    public function exportPengaduan(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query = Pengaduan::with('user', 'admin');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')->get();

        if ($format === 'pdf') {
            return $this->exportPengaduanPDF($pengaduans);
        }

        return $this->exportPengaduanCSV($pengaduans);
    }

    /**
     * Export pengaduan to CSV
     */
    private function exportPengaduanCSV($pengaduans)
    {
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
     * Export pengaduan to PDF
     */
    private function exportPengaduanPDF($pengaduans)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN PENGADUAN MASYARAKAT', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Tanggal: ' . now()->format('d/m/Y H:i'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'Judul', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Kategori', 1, 0, 'C', true);
        $pdf->Cell(35, 7, 'Pelapor', 1, 0, 'C', true);
        $pdf->Cell(20, 7, 'Status', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $no = 1;

        foreach ($pengaduans as $pengaduan) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, $pengaduan->tanggal_pengaduan->format('d/m/Y'), 1, 0, 'L');
            $pdf->Cell(50, 6, substr($pengaduan->judul, 0, 20), 1, 0, 'L');
            $pdf->Cell(25, 6, ucfirst($pengaduan->kategori), 1, 0, 'L');
            $pdf->Cell(35, 6, substr($pengaduan->user->name, 0, 15), 1, 0, 'L');
            $pdf->Cell(20, 6, ucfirst($pengaduan->status), 1, 1, 'C');
        }

        $filename = 'pengaduan_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export bansos to CSV
     */
    public function exportBansos(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query = Bansos::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bansos = $query->orderBy('tanggal_mulai', 'desc')->get();

        if ($format === 'pdf') {
            return $this->exportBansosPDF($bansos);
        }

        return $this->exportBansosCSV($bansos);
    }

    /**
     * Export bansos to CSV
     */
    private function exportBansosCSV($bansos)
    {
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
     * Export bansos to PDF
     */
    private function exportBansosPDF($bansos)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN PROGRAM BANTUAN SOSIAL', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Tanggal: ' . now()->format('d/m/Y H:i'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Program', 1, 0, 'C', true);
        $pdf->Cell(20, 7, 'Kuota', 1, 0, 'C', true);
        $pdf->Cell(20, 7, 'Terpakai', 1, 0, 'C', true);
        $pdf->Cell(35, 7, 'Nominal', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Status', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $no = 1;

        foreach ($bansos as $program) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(40, 6, substr($program->nama_bansos, 0, 20), 1, 0, 'L');
            $pdf->Cell(20, 6, $program->kuota, 1, 0, 'C');
            $pdf->Cell(20, 6, $program->kuota_terpakai, 1, 0, 'C');
            $pdf->Cell(35, 6, 'Rp ' . number_format($program->nominal, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(25, 6, ucfirst($program->status), 1, 1, 'C');
        }

        $filename = 'bansos_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export penerima bansos to CSV
     */
    public function exportPenerimaBansos(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query = PenerimaBansos::with('bansos', 'user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('bansos_id')) {
            $query->where('bansos_id', $request->bansos_id);
        }

        $penerima = $query->orderBy('created_at', 'desc')->get();

        if ($format === 'pdf') {
            return $this->exportPenerimaBansosPDF($penerima);
        }

        return $this->exportPenerimaBansosCSV($penerima);
    }

    /**
     * Export penerima bansos to CSV
     */
    private function exportPenerimaBansosCSV($penerima)
    {
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
                $item->user->name,
                $item->user->nik,
                $item->user->no_hp,
                $item->user->alamat,
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
     * Export penerima bansos to PDF
     */
    private function exportPenerimaBansosPDF($penerima)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN PENERIMA BANTUAN SOSIAL', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Tanggal: ' . now()->format('d/m/Y H:i'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(8, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Program', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Nama', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'NIK', 1, 0, 'C', true);
        $pdf->Cell(20, 7, 'Status', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Nominal', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        $no = 1;

        foreach ($penerima as $item) {
            $pdf->Cell(8, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, substr($item->bansos->nama_bansos, 0, 15), 1, 0, 'L');
            $pdf->Cell(30, 6, substr($item->user->name, 0, 15), 1, 0, 'L');
            $pdf->Cell(25, 6, $item->user->nik, 1, 0, 'L');
            $pdf->Cell(20, 6, ucfirst($item->status), 1, 0, 'C');
            $pdf->Cell(30, 6, $item->nominal_diterima ? 'Rp ' . number_format($item->nominal_diterima, 0, ',', '.') : '-', 1, 1, 'R');
        }

        $filename = 'penerima_bansos_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export pengajuan surat to CSV
     */
    public function exportPengajuanSurat(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query = PengajuanSurat::with('user', 'jenisSurat');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->get();

        if ($format === 'pdf') {
            return $this->exportPengajuanSuratPDF($pengajuans);
        }

        return $this->exportPengajuanSuratCSV($pengajuans);
    }

    /**
     * Export pengajuan surat to CSV
     */
    private function exportPengajuanSuratCSV($pengajuans)
    {
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

    /**
     * Export pengajuan surat to PDF
     */
    private function exportPengajuanSuratPDF($pengajuans)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN PENGAJUAN SURAT', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Tanggal: ' . now()->format('d/m/Y H:i'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell(35, 7, 'Pemohon', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Jenis Surat', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Status', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $no = 1;

        foreach ($pengajuans as $pengajuan) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, $pengajuan->created_at->format('d/m/Y'), 1, 0, 'L');
            $pdf->Cell(35, 6, substr($pengajuan->user->name, 0, 18), 1, 0, 'L');
            $pdf->Cell(40, 6, substr($pengajuan->jenisSurat->nama_surat ?? '-', 0, 20), 1, 0, 'L');
            $pdf->Cell(25, 6, ucfirst($pengajuan->status), 1, 1, 'C');
        }

        $filename = 'pengajuan_surat_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
