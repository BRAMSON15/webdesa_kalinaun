<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arsip Pengajuan Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; cursor: pointer; margin-left: 10px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="header">
        <h2>PEMERINTAH DESA MAJU JAYA</h2>
        <h3>LAPORAN ARSIP PENGAJUAN SURAT</h3>
        <p>Jl. Raya Desa No. 1, Kecamatan Maju, Kabupaten Sejahtera</p>
        <p>Telp: 021-1234567 | Email: info@desamajujaya.go.id</p>
    </div>

    <div class="info">
        <table style="border: none; width: 50%;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;"><strong>Tanggal Cetak</strong></td>
                <td style="border: none;">: {{ date('d F Y') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Periode</strong></td>
                <td style="border: none;">: 
                    @if(request('bulan'))
                        {{ date('F', mktime(0, 0, 0, request('bulan'), 1)) }}
                    @else
                        Semua Bulan
                    @endif
                    @if(request('tahun'))
                        {{ request('tahun') }}
                    @else
                        (Semua Tahun)
                    @endif
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Status</strong></td>
                <td style="border: none;">: 
                    @if(request('status') == 'selesai')
                        Disetujui
                    @elseif(request('status') == 'ditolak')
                        Ditolak
                    @else
                        Semua Status
                    @endif
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Data</strong></td>
                <td style="border: none;">: {{ $laporan->count() }} pengajuan</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">ID</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pemohon</th>
                <th width="12%">NIK</th>
                <th width="15%">Jenis Surat</th>
                <th width="25%">Keterangan</th>
                <th width="8%">Status</th>
                <th width="10%">Diproses</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $arsip)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>#{{ str_pad($arsip->id_surat, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $arsip->tgl_pengajuan->format('d/m/Y') }}</td>
                <td>{{ $arsip->masyarakat->nama }}</td>
                <td>{{ $arsip->masyarakat->nik }}</td>
                <td>{{ $arsip->jenis_surat }}</td>
                <td>{{ Str::limit($arsip->keterangan, 80) }}</td>
                <td>{{ $arsip->status == 'selesai' ? 'Disetujui' : 'Ditolak' }}</td>
                <td>{{ $arsip->updated_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;"><strong>Total Pengajuan:</strong> {{ $laporan->count() }}</td>
                <td style="border: none; width: 25%;"><strong>Disetujui:</strong> {{ $laporan->where('status', 'selesai')->count() }}</td>
                <td style="border: none; width: 25%;"><strong>Ditolak:</strong> {{ $laporan->where('status', 'ditolak')->count() }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Desa Maju Jaya, {{ date('d F Y') }}</p>
        <p><strong>Sekretaris Desa</strong></p>
        <div class="signature">
            <p>_______________________</p>
            <p><strong>{{ auth('sekdes')->user()->username }}</strong></p>
        </div>
    </div>
</body>
</html>