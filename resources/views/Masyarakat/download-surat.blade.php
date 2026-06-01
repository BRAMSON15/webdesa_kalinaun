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
            font-size: 12pt;
            background: #e8e8e8;
            color: #000;
        }

        /* ===== TOMBOL KONTROL ===== */
        .print-controls {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 999;
            display: flex;
            gap: 6px;
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .print-controls button {
            padding: 6px 16px;
            font-size: 11pt;
            border: 1px solid #888;
            border-radius: 4px;
            cursor: pointer;
            background: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .btn-print {
            background: #2196F3 !important;
            color: #fff !important;
            border-color: #1976D2 !important;
        }

        .btn-print:hover { background: #1976D2 !important; }

        .print-controls button:hover {
            background: #ddd;
        }

        /* ===== HALAMAN SURAT ===== */
        .page {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            margin: 30px auto;
            padding: 20mm 20mm 15mm 25mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 8px;
            border-bottom: 4px double #000;
            margin-bottom: 16px;
        }

        .logo-kab {
            width: 75px;
            height: 75px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .header-text {
            text-align: center;
            flex: 1;
            line-height: 1.4;
        }

        .header-text h3 {
            font-size: 11pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .header-text h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-text h1 {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-text p {
            font-size: 9pt;
            color: #333;
            margin-top: 2px;
        }

        /* ===== JUDUL SURAT ===== */
        .judul-container {
            text-align: center;
            margin: 18px 0 12px;
        }

        .judul-surat {
            display: block;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nomor-surat {
            display: block;
            font-size: 11pt;
            margin-top: 4px;
        }

        /* ===== ISI SURAT ===== */
        .isi-surat {
            line-height: 1.8;
        }

        .pembukaan {
            text-indent: 40px;
            margin-bottom: 12px;
            text-align: justify;
        }

        /* ===== TABEL DATA ===== */
        .data-tabel {
            margin: 10px 0 16px 20px;
        }

        .data-row {
            display: flex;
            margin-bottom: 4px;
        }

        .data-label {
            width: 180px;
            flex-shrink: 0;
            font-weight: normal;
        }

        .data-label::after {
            content: ':';
            margin-left: 4px;
        }

        .data-value {
            flex: 1;
            padding-left: 10px;
        }

        /* ===== PENUTUP ===== */
        .penutup {
            text-indent: 40px;
            margin-bottom: 10px;
            text-align: justify;
        }

        .keterangan-tambahan {
            text-indent: 40px;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .ttd-box {
            width: 45%;
            text-align: center;
        }

        .ttd-date {
            margin-bottom: 4px;
            font-size: 11pt;
        }

        .ttd-jabatan {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .ttd-nama {
            display: block;
            font-weight: bold;
            text-decoration: underline;
            font-size: 11pt;
        }

        .ttd-nip {
            display: block;
            font-size: 10pt;
        }

        /* ===== ATURAN CETAK ===== */
        @media print {
            body {
                background: #fff;
            }

            .print-controls {
                display: none !important;
            }

            .page {
                width: 100%;
                margin: 0;
                padding: 15mm 20mm 15mm 25mm;
                box-shadow: none;
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.history.back()">← Kembali</button>
    </div>

    <div class="page">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Kab" class="logo-kab">
            <div class="header-text">
                <h3>PEMERINTAH KABUPATEN MINAHASA UTARA</h3>
                <h2>KECAMATAN KALAWAT</h2>
                <h1>DESA KALINAUN</h1>
                <p>Jl. Raya Desa No. 1, Kode Pos 95371 &nbsp;|&nbsp; Email: desakalinaun@gmail.com</p>
            </div>
        </div>

        <!-- Judul Surat -->
        <div class="judul-container">
            <span class="judul-surat">{{ strtoupper($pengajuan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN') }}</span>
            <span class="nomor-surat">Nomor: {{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}/SK/DESKAL/{{ date('Y') }}</span>
        </div>

        <!-- Isi Surat -->
        <div class="isi-surat">
            <p class="pembukaan">
                Yang bertanda tangan di bawah ini, Kepala Desa Kalinaun Kecamatan Kalawat Kabupaten Minahasa Utara, menerangkan dengan sesungguhnya bahwa:
            </p>

            <div class="data-tabel">
                <div class="data-row">
                    <div class="data-label">Nama</div>
                    <div class="data-value">{{ strtoupper($pengajuan->user->name ?? '-') }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Jenis Kelamin</div>
                    <div class="data-value">
                        {{ $pengajuan->user->jenis_kelamin == 'L' ? 'Laki-laki' : ($pengajuan->user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Tempat, Tgl Lahir</div>
                    <div class="data-value">
                        {{ $pengajuan->user->tempat_lahir ?? '-' }},
                        {{ $pengajuan->user->tanggal_lahir ? \Carbon\Carbon::parse($pengajuan->user->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </div>
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
                    <div class="data-label">Nomor NIK / KTP</div>
                    <div class="data-value">{{ $pengajuan->user->nik ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Alamat</div>
                    <div class="data-value">
                        {{ $pengajuan->user->alamat ?? 'Desa Kalinaun' }},
                        Kecamatan Kalawat, Kabupaten Minahasa Utara.
                    </div>
                </div>
            </div>

            <p class="penutup">
                Adalah benar-benar penduduk Desa Kalinaun, Kecamatan Kalawat, Kabupaten Minahasa Utara dan saat ini yang bersangkutan berada di wilayah kami.
            </p>

            <p class="keterangan-tambahan">
                Surat keterangan ini diberikan untuk keperluan <strong>{{ $pengajuan->keperluan ?? 'Administrasi' }}</strong>.
            </p>

            <p class="penutup" style="text-indent: 0;">
                Demikian surat keterangan ini dibuat dengan sebenar-benarnya dan hendaknya yang berkepentingan menjadikan periksa adanya.
            </p>
        </div>

        <!-- Tanda Tangan -->
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
</body>
</html>
