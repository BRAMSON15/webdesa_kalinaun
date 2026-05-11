<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat - {{ $pengajuan->jenisSurat->nama_surat ?? 'Surat' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .kop-surat h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .kop-surat h2 {
            margin: 5px 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .kop-surat p {
            margin: 2px 0;
            font-size: 12px;
        }
        
        .nomor-surat {
            text-align: center;
            margin: 20px 0;
        }
        
        .nomor-surat h3 {
            margin: 0;
            font-size: 16px;
            text-decoration: underline;
            font-weight: bold;
        }
        
        .nomor {
            margin: 10px 0;
            font-size: 14px;
        }
        
        .isi-surat {
            margin: 30px 0;
            text-align: justify;
        }
        
        .isi-surat p {
            margin: 15px 0;
            text-indent: 30px;
        }
        
        .data-pemohon {
            margin: 20px 0;
        }
        
        .data-pemohon table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-pemohon td {
            padding: 5px;
            vertical-align: top;
        }
        
        .ttd {
            margin-top: 50px;
            text-align: right;
            width: 300px;
            float: right;
        }
        
        .ttd p {
            margin: 5px 0;
        }
        
        .ttd-space {
            height: 80px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="no-print print-button">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Surat
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN MINAHASA UTARA</h1>
        <h2>DESA KALINAUN</h2>
        <p>Alamat: Jl. Raya Desa Kalinaun, Kecamatan Kalawat</p>
        <p>Kode Pos: 95371 | Telepon: (0431) 123456</p>
        <p>Email: desakalinaun@gmail.com</p>
    </div>

    <!-- Nomor Surat -->
    <div class="nomor-surat">
        <h3>{{ $pengajuan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN' }}</h3>
        <div class="nomor">
            Nomor: {{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}/SKD/{{ date('Y') }}
        </div>
    </div>

    <!-- Isi Surat -->
    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa Kalinaun Kecamatan Kalawat Kabupaten Minahasa Utara, dengan ini menerangkan bahwa:</p>
        
        <div class="data-pemohon">
            <table>
                <tr>
                    <td width="150">Nama</td>
                    <td width="20">:</td>
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
                    <td>{{ $pengajuan->user->tempat_lahir ?? '-' }}, {{ $pengajuan->user->tanggal_lahir ? \Carbon\Carbon::parse($pengajuan->user->tanggal_lahir)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $pengajuan->user->jenis_kelamin == 'L' ? 'Laki-laki' : ($pengajuan->user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
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

        <p>Adalah benar warga Desa Kalinaun dan berdomisili di alamat tersebut di atas.</p>
        
        <p><strong>Keperluan:</strong> {{ $pengajuan->keperluan ?? 'Keperluan administrasi' }}</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <p>Kalinaun, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p><strong>Kepala Desa Kalinaun</strong></p>
        <div class="ttd-space"></div>
        <p><strong><u>Bapak Siamto Ruyat</u></strong></p>
        <p>NIP. 19700101 199803 1 001</p>
    </div>

    <div style="clear: both;"></div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>