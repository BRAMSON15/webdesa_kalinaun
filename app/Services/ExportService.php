<?php

namespace App\Services;

use App\Models\Pengaduan;
use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportService
{
    /**
     * Export pengaduan
     */
    public function exportPengaduan($filters = [])
    {
        $query = Pengaduan::with('user', 'admin');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        return $query->orderBy('tanggal_pengaduan', 'desc')->get();
    }

    /**
     * Export pengaduan to Excel (HTML table as .xls)
     */
    public function exportPengaduanCSV($pengaduans)
    {
        $filename = 'pengaduan_' . now()->format('Y-m-d_H-i-s') . '.xls';

        $html = $this->buildExcelHtml('Laporan Pengaduan Masyarakat', [
            'No', 'Tanggal', 'Judul', 'Kategori', 'Pelapor', 'Status', 'Catatan Admin', 'Tanggal Selesai'
        ], $pengaduans->map(function ($p, $i) {
            return [
                $i + 1,
                $p->tanggal_pengaduan->format('d/m/Y H:i'),
                $p->judul,
                ucfirst($p->kategori),
                $p->user->name,
                ucfirst($p->status),
                $p->catatan_admin ?? '-',
                $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y H:i') : '-',
            ];
        })->toArray());

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export pengaduan to PDF
     */
    public function exportPengaduanPDF($pengaduans)
    {
        $data = [
            'title'   => 'LAPORAN PENGADUAN MASYARAKAT',
            'date'    => now()->format('d/m/Y H:i'),
            'headers' => ['No', 'Tanggal', 'Judul', 'Kategori', 'Pelapor', 'Status'],
            'rows'    => $pengaduans->map(function ($p, $i) {
                return [
                    $i + 1,
                    $p->tanggal_pengaduan->format('d/m/Y'),
                    $p->judul,
                    ucfirst($p->kategori),
                    $p->user->name,
                    ucfirst($p->status),
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('exports.pdf-table', $data)->setPaper('a4', 'landscape');
        $filename = 'pengaduan_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export bansos
     */
    public function exportBansos($filters = [])
    {
        $query = Bansos::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('tanggal_mulai', 'desc')->get();
    }

    /**
     * Export bansos to Excel
     */
    public function exportBansosCSV($bansos)
    {
        $filename = 'bansos_' . now()->format('Y-m-d_H-i-s') . '.xls';

        $html = $this->buildExcelHtml('Laporan Program Bantuan Sosial', [
            'No', 'Nama Program', 'Jenis', 'Kuota', 'Kuota Terpakai', 'Nominal', 'Tgl Mulai', 'Tgl Selesai', 'Status'
        ], $bansos->map(function ($p, $i) {
            return [
                $i + 1,
                $p->nama_bansos,
                $p->jenis_bansos ?? '-',
                $p->kuota,
                $p->kuota_terpakai,
                'Rp ' . number_format($p->nominal, 0, ',', '.'),
                $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-',
                $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-',
                ucfirst($p->status),
            ];
        })->toArray());

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export bansos to PDF
     */
    public function exportBansosPDF($bansos)
    {
        $data = [
            'title'   => 'LAPORAN PROGRAM BANTUAN SOSIAL',
            'date'    => now()->format('d/m/Y H:i'),
            'headers' => ['No', 'Nama Program', 'Kuota', 'Terpakai', 'Nominal', 'Status'],
            'rows'    => $bansos->map(function ($p, $i) {
                return [
                    $i + 1,
                    $p->nama_bansos,
                    $p->kuota,
                    $p->kuota_terpakai,
                    'Rp ' . number_format($p->nominal, 0, ',', '.'),
                    ucfirst($p->status),
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('exports.pdf-table', $data)->setPaper('a4', 'landscape');
        $filename = 'bansos_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export penerima bansos
     */
    public function exportPenerimaBansos($filters = [])
    {
        $query = PenerimaBansos::with('bansos', 'user');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['bansos_id'])) {
            $query->where('bansos_id', $filters['bansos_id']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Export penerima bansos to Excel
     */
    public function exportPenerimaBansosCSV($penerima)
    {
        $filename = 'penerima_bansos_' . now()->format('Y-m-d_H-i-s') . '.xls';

        $html = $this->buildExcelHtml('Laporan Penerima Bantuan Sosial', [
            'No', 'Program', 'Nama Penerima', 'NIK', 'No. HP', 'Alamat', 'Status', 'Nominal', 'Tgl Penerimaan'
        ], $penerima->map(function ($item, $i) {
            return [
                $i + 1,
                $item->bansos->nama_bansos ?? '-',
                $item->nama_penerima ?? ($item->user->name ?? '-'),
                $item->nik ?? ($item->user->nik ?? '-'),
                $item->no_hp ?? ($item->user->no_hp ?? '-'),
                $item->alamat ?? ($item->user->alamat ?? '-'),
                ucfirst($item->status),
                $item->nominal_diterima ? 'Rp ' . number_format($item->nominal_diterima, 0, ',', '.') : '-',
                $item->tanggal_penerimaan ? $item->tanggal_penerimaan->format('d/m/Y') : '-',
            ];
        })->toArray());

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export penerima bansos to PDF
     */
    public function exportPenerimaBansosPDF($penerima)
    {
        $data = [
            'title'   => 'LAPORAN PENERIMA BANTUAN SOSIAL',
            'date'    => now()->format('d/m/Y H:i'),
            'headers' => ['No', 'Program', 'Nama Penerima', 'NIK', 'Status', 'Nominal'],
            'rows'    => $penerima->map(function ($item, $i) {
                return [
                    $i + 1,
                    $item->bansos->nama_bansos ?? '-',
                    $item->nama_penerima ?? ($item->user->name ?? '-'),
                    $item->nik ?? ($item->user->nik ?? '-'),
                    ucfirst($item->status),
                    $item->nominal_diterima ? 'Rp ' . number_format($item->nominal_diterima, 0, ',', '.') : '-',
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('exports.pdf-table', $data)->setPaper('a4', 'landscape');
        $filename = 'penerima_bansos_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export pengajuan surat
     */
    public function exportPengajuanSurat($filters = [])
    {
        $query = PengajuanSurat::with('user', 'jenisSurat');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Export pengajuan surat to Excel
     */
    public function exportPengajuanSuratCSV($pengajuans)
    {
        $filename = 'pengajuan_surat_' . now()->format('Y-m-d_H-i-s') . '.xls';

        $html = $this->buildExcelHtml('Laporan Pengajuan Surat', [
            'No', 'Tanggal', 'Nama Pemohon', 'NIK', 'Jenis Surat', 'Keperluan', 'Status'
        ], $pengajuans->map(function ($p, $i) {
            return [
                $i + 1,
                $p->created_at->format('d/m/Y H:i'),
                $p->user->name,
                $p->user->nik ?? '-',
                $p->jenisSurat->nama_surat ?? '-',
                $p->keperluan,
                ucfirst($p->status),
            ];
        })->toArray());

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export pengajuan surat to PDF
     */
    public function exportPengajuanSuratPDF($pengajuans)
    {
        $data = [
            'title'   => 'LAPORAN PENGAJUAN SURAT',
            'date'    => now()->format('d/m/Y H:i'),
            'headers' => ['No', 'Tanggal', 'Nama Pemohon', 'Jenis Surat', 'Keperluan', 'Status'],
            'rows'    => $pengajuans->map(function ($p, $i) {
                return [
                    $i + 1,
                    $p->created_at->format('d/m/Y'),
                    $p->user->name,
                    $p->jenisSurat->nama_surat ?? '-',
                    $p->keperluan,
                    ucfirst($p->status),
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('exports.pdf-table', $data)->setPaper('a4', 'landscape');
        $filename = 'pengajuan_surat_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Build a styled HTML table for Excel export
     */
    private function buildExcelHtml(string $title, array $headers, array $rows): string
    {
        $headerCells = '';
        foreach ($headers as $h) {
            $headerCells .= "<th style=\"background-color:#2d6a4f;color:#ffffff;font-weight:bold;padding:8px 12px;border:1px solid #ccc;white-space:nowrap;\">$h</th>";
        }

        $bodyRows = '';
        foreach ($rows as $idx => $row) {
            $bg = ($idx % 2 === 0) ? '#ffffff' : '#f0faf4';
            $cells = '';
            foreach ($row as $cell) {
                $val = htmlspecialchars((string)$cell);
                $cells .= "<td style=\"padding:6px 12px;border:1px solid #ddd;background-color:{$bg};\">$val</td>";
            }
            $bodyRows .= "<tr>$cells</tr>";
        }

        return <<<HTML
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="SIPAKAL Desa Kalinaun">
<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
<x:Name>Laporan</x:Name>
<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
</head>
<body>
<table style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:12px;">
  <tr>
    <td colspan="{$this->count($headers)}" style="font-size:16px;font-weight:bold;color:#2d6a4f;padding:10px 12px;">
      SIPAKAL – Desa Kalinaun
    </td>
  </tr>
  <tr>
    <td colspan="{$this->count($headers)}" style="font-size:13px;font-weight:bold;padding:4px 12px 10px;">
      {$title}
    </td>
  </tr>
  <tr>
    <td colspan="{$this->count($headers)}" style="font-size:11px;color:#666;padding:0 12px 12px;">
      Dicetak pada: {$this->nowFormatted()}
    </td>
  </tr>
  <tr>$headerCells</tr>
  $bodyRows
</table>
</body>
</html>
HTML;
    }

    private function count(array $arr): int
    {
        return count($arr);
    }

    private function nowFormatted(): string
    {
        return now()->format('d/m/Y H:i');
    }
}
