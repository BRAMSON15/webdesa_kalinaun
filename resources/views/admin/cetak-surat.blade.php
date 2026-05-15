<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat' }} - {{ $pengajuan->user->name ?? 'Warga' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #000;
            background: #f5f5f5;
        }

        .page {
            width: 210mm;
            height: 297mm;
            margin: 10mm auto;
            padding: 20mm;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Header Section */
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15mm;
            margin-bottom: 10mm;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10mm;
        }

        .logo-section {
            width: 20mm;
            height: 20mm;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14pt;
            font-weight: bold;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-text .pemerintah {
            font-size: 10pt;
            font-weight: normal;
            letter-spacing: 1px;
        }

        .header-text .desa {
            font-size: 18pt;
            font-weight: bold;
            margin: 3mm 0;
            letter-spacing: 2px;
        }

        .header-text .alamat {
            font-size: 9pt;
            line-height: 1.4;
            margin-top: 2mm;
        }

        .header-text .alamat p {
            margin: 1mm 0;
        }

        /* Judul Surat */
        .judul-surat {
            text-align: center;
            margin: 15mm 0 10mm 0;
        }

        .judul-surat h2 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3mm;
            letter-spacing: 1px;
        }

        .nomor-surat {
            font-size: 11pt;
            margin: 2mm 0;
        }

        /* Pembukaan Surat */
        .pembukaan {
            text-align: center;
            font-size: 10pt;
            margin: 10mm 0;
            font-style: italic;
        }

        /* Isi Surat */
        .isi-surat {
            margin: 15mm 0;
            text-align: justify;
            font-size: 11pt;
            line-height: 1.8;
        }

        .isi-surat p {
            margin-bottom: 8mm;
            text-indent: 15mm;
        }

        .isi-surat p.no-indent {
            text-indent: 0;
        }

        /* Data Tabel */
        .data-section {
            margin: 12mm 0;
        }

        .data-section h4 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5mm;
            text-decoration: underline;
        }

        .data-table {
            width: 100%;
            margin: 8mm 0;
            font-size: 10pt;
        }

        .data-table tr {
            height: 6mm;
        }

        .data-table td {
            padding: 2mm 3mm;
            vertical-align: top;
        }

        .data-table td:first-child {
            width: 35mm;
            font-weight: normal;
        }

        .data-table td:nth-child(2) {
            width: 8mm;
            text-align: center;
        }

        /* Pernyataan */
        .pernyataan {
            margin: 12mm 0;
            text-align: justify;
            font-size: 11pt;
            line-height: 1.8;
        }

        .pernyataan p {
            margin-bottom: 6mm;
            text-indent: 15mm;
        }

        /* Tanda Tangan */
        .ttd-section {
            margin-top: 20mm;
            display: flex;
            justify-content: space-between;
        }

        .ttd-box {
            width: 45%;
            text-align: center;
        }

        .ttd-tempat {
            font-size: 10pt;
            margin-bottom: 15mm;
            text-align: right;
        }

        .ttd-tempat strong {
            font-weight: bold;
        }

        .ttd-nama {
            margin-top: 20mm;
            font-size: 10pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-nip {
            font-size: 9pt;
            margin-top: 2mm;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .page {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 20mm;
                box-shadow: none;
                page-break-after: always;
            }

            .no-print {
                display: none !important;
            }

            button {
                display: none !important;
            }
        }

        /* Print Button */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }

        .print-controls button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-print {
            background: #3498db;
            color: white;
        }

        .btn-print:hover {
            background: #2980b9;
        }

        .btn-close {
            background: #95a5a6;
            color: white;
        }

        .btn-close:hover {
            background: #7f8c8d;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page {
                width: 100%;
                margin: 0;
                padding: 15mm;
            }

            .ttd-section {
                flex-direction: column;
            }

            .ttd-box {
                width: 100%;
                margin-bottom: 20mm;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls no-print">
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak
        </button>
        <button class="btn-close" onclick="window.close()">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="header-top">
                <div class="logo-section">
                    🏛️
                </div>
                <div class="header-text">
                    <div class="pemerintah">PEMERINTAH KABUPATEN MINAHASA UTARA</div>
                    <div class="desa">DESA KALINAUN</div>
                    <div class="alamat">
                        <p>Alamat: Jl. Raya Desa No. 1, Kecamatan Kalawat</p>
                        <p>Kode Pos: 95371 | Telepon: (0431) 123456</p>
                        <p>Email: desakalinaun@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Judul Surat -->
        <div class="judul-surat">
            <h2>{{ $pengajuan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN' }}</h2>
            <div class="nomor-surat">
                Nomor: {{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}/SKD/{{ date('Y') }}
            </div>
        </div>

        <!-- Pembukaan -->
        <div class="pembukaan">
            Yang bertanda tangan di bawah ini, Kepala Desa Kalinaun Kecamatan Kalawat Kabupaten Minahasa Utara, dengan ini menerangkan bahwa:
        </div>

        <!-- Data Pemohon -->
        <div class="data-section">
            <table class="data-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $pengajuan->user->name ?? 'N/A' }}</strong></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tempat/Tgl Lahir</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->tempat_lahir ?? '-' }}, {{ $pengajuan->user->tanggal_lahir ? \Carbon\Carbon::parse(->user->tanggal_lahir)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->jenis_kelamin == 'L' ? 'Laki-laki' : (->user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Isi Surat -->
        <div class="isi-surat">
            <p>Adalah benar warga Desa Kalinaun dan berdomisili di alamat tersebut di atas.</p>
            
            <p class="no-indent"><strong>Keperluan:</strong> {{ $pengajuan->keperluan ?? 'Keperluan administrasi' }}</p>
        </div>

        <!-- Pernyataan -->
        <div class="pernyataan">
            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <!-- Tanda Tangan -->
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="ttd-tempat">
                    <strong>Kalinaun</strong>, {{ \Carbon\Carbon::now()->format('d F Y') }}
                </div>
                <div style="text-align: center;">
                    <strong>Kepala Desa Kalinaun</strong>
                </div>
                <div style="height: 25mm;"></div>
                <div class="ttd-nama">Bapak Siamto Ruyat</div>
                <div class="ttd-nip">NIP. 19700101 199803 1 001</div>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus print dialog on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
