<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat' }} - {{ $pengajuan->user->name ?? 'Warga' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            color: #000;
            background: #f0f0f0;
            -webkit-print-color-adjust: exact;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 25mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Header / Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px double #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .logo-kab {
            width: 80px;
            height: auto;
            margin-right: 20px;
        }

        .header-text {
            flex-grow: 1;
            text-align: center;
            margin-right: 80px; /* Offset to keep text centered relative to page */
        }

        .header-text h3 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .header-text h2 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .header-text h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .header-text p {
            font-size: 10pt;
            font-style: italic;
        }

        /* Judul Surat */
        .judul-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul-surat {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .nomor-surat {
            font-size: 11pt;
        }

        /* Isi Surat */
        .isi-surat {
            font-size: 11pt;
            text-align: justify;
        }

        .pembukaan {
            margin-bottom: 15px;
            text-indent: 40px;
        }

        /* Data Section */
        .data-tabel {
            margin-left: 50px;
            margin-bottom: 15px;
            width: calc(100% - 50px);
        }

        .data-row {
            display: flex;
            margin-bottom: 4px;
        }

        .data-label {
            width: 160px;
            position: relative;
        }

        .data-label::after {
            content: ":";
            position: absolute;
            right: 15px;
        }

        .data-value {
            flex: 1;
            font-weight: bold;
        }

        .penutup {
            margin-top: 15px;
            margin-bottom: 15px;
            text-indent: 40px;
        }

        .keterangan-tambahan {
            margin-bottom: 25px;
            text-indent: 40px;
        }

        /* Signature Section */
        .ttd-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .ttd-box {
            width: 250px;
            text-align: center;
        }

        .ttd-box.left {
            text-align: center;
        }

        .ttd-box.right {
            text-align: center;
        }

        .ttd-date {
            margin-bottom: 5px;
        }

        .ttd-jabatan {
            margin-bottom: 70px;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            display: block;
        }

        .ttd-nip {
            display: block;
            font-size: 10pt;
        }

        /* Controls */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-print:hover {
            background: #0056b3;
        }

        .btn-close {
            background: #6c757d;
            color: white;
        }

        /* Media Print */
        @media print {
            body {
                background: white;
            }
            .page {
                margin: 0;
                box-shadow: none;
                width: 210mm;
                height: 297mm;
            }
            .print-controls {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button class="btn btn-print" onclick="window.print()">Cetak</button>
        <button class="btn btn-close" onclick="window.close()">Tutup</button>
    </div>

    <div class="page">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Kab" class="logo-kab">
            <div class="header-text">
                <h3>PEMERINTAH KABUPATEN MINAHASA UTARA</h3>
                <h2>KECAMATAN KALAWAT</h2>
                <h1>DESA KALINAUN</h1>
                <p>Jl. Raya Desa No. 1, Kode Pos 95371 | Email: desakalinaun@gmail.com</p>
            </div>
        </div>

        <!-- Judul Surat -->
        <div class="judul-container">
            <span class="judul-surat">{{ strtoupper($pengajuan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN') }}</span>
            <span class="nomor-surat">Nomor: {{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}/SK/{{ date('Y') }}</span>
        </div>

        <div class="isi-surat">
            <p class="pembukaan">
                Yang bertanda tangan di bawah ini Kami Kepala Desa Kalinaun Kecamatan Kalawat Kabupaten Minahasa Utara menerangkan dengan sebenarnya bahwa di Kartu Keluarga :
            </p>

            <div class="data-tabel">
                <div class="data-row">
                    <div class="data-label">Nama</div>
                    <div class="data-value">{{ strtoupper($pengajuan->user->name ?? '-') }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Jenis Kelamin</div>
                    <div class="data-value">{{ $pengajuan->user->jenis_kelamin == 'L' ? 'Laki-laki' : ($pengajuan->user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Tempat, Tgl Lahir</div>
                    <div class="data-value">{{ $pengajuan->user->tempat_lahir ?? '-' }}, {{ $pengajuan->user->tanggal_lahir ? \Carbon\Carbon::parse($pengajuan->user->tanggal_lahir)->format('d F Y') : '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Agama</div>
                    <div class="data-value">{{ $pengajuan->user->agama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Kewarganegaraan</div>
                    <div class="data-value">Indonesia</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Pendidikan</div>
                    <div class="data-value">{{ $pengajuan->user->pendidikan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Pekerjaan</div>
                    <div class="data-value">{{ $pengajuan->user->pekerjaan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Nomor NIK/KTP</div>
                    <div class="data-value">{{ $pengajuan->user->nik ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Alamat</div>
                    <div class="data-value">
                        {{ $pengajuan->user->alamat ?? '-' }}<br>
                        Desa Kalinaun, Kecamatan Kalawat, Kabupaten Minahasa Utara.
                    </div>
                </div>
            </div>

            <p class="penutup">
                Menerangkan dengan sebenarnya bahwa orang tersebut di atas benar-benar penduduk Desa Kalinaun, Kecamatan Kalawat, Kabupaten Minahasa Utara.
            </p>

            <p class="keterangan-tambahan">
                Surat keterangan ini akan dipergunakan untuk keperluan <strong>{{ $pengajuan->keperluan ?? 'Administrasi' }}</strong>.
            </p>

            <p class="penutup" style="text-indent: 0;">
                Demikian surat keterangan ini dibuat dengan sebenar-benarnya dan hendaknya yang berkepentingan menjadikan periksa adanya.
            </p>
        </div>

        <!-- Tanda Tangan Section -->
        <div class="ttd-container">
            <div class="ttd-box left">
                <div class="ttd-date">&nbsp;</div>
                <div class="ttd-jabatan">Pemegang Surat</div>
                <span class="ttd-nama">{{ strtoupper($pengajuan->user->name ?? 'N/A') }}</span>
                <span class="ttd-nip">NIK. {{ $pengajuan->user->nik ?? '-' }}</span>
            </div>

            <div class="ttd-box right">
                <div class="ttd-date">Kalinaun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="ttd-jabatan">Kepala Desa Kalinaun</div>
                <span class="ttd-nama">Bapak Siamto Ruyat</span>
                <span class="ttd-nip">NIP. 19700101 199803 1 001</span>
            </div>
        </div>
    </div>

    <script>
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
</html>
