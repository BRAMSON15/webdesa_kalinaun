<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
            background: #fff;
        }

        /* ===== KOP SURAT ===== */
        .kop {
            width: 100%;
            border-bottom: 3px solid #2d6a4f;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .kop-inner {
            display: table;
            width: 100%;
        }

        .kop-logo {
            display: table-cell;
            width: 60px;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 55px;
            height: 55px;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 12px;
        }

        .kop-text h1 {
            font-size: 15px;
            font-weight: bold;
            color: #2d6a4f;
            margin: 0 0 2px 0;
        }

        .kop-text p {
            font-size: 10px;
            color: #555;
            margin: 0;
        }

        /* ===== JUDUL LAPORAN ===== */
        .report-title {
            text-align: center;
            margin-bottom: 4px;
        }

        .report-title h2 {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-meta {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-bottom: 16px;
        }

        /* ===== TABEL ===== */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10px;
        }

        table.data-table thead tr th {
            background-color: #2d6a4f;
            color: #ffffff;
            font-weight: bold;
            padding: 7px 8px;
            border: 1px solid #1f4f36;
            text-align: center;
            white-space: nowrap;
        }

        table.data-table tbody tr td {
            padding: 6px 8px;
            border: 1px solid #dde;
            vertical-align: top;
        }

        table.data-table tbody tr:nth-child(even) td {
            background-color: #f0faf4;
        }

        table.data-table tbody tr:nth-child(odd) td {
            background-color: #ffffff;
        }

        table.data-table td:first-child {
            text-align: center;
            white-space: nowrap;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 24px;
            font-size: 9px;
            color: #999;
            text-align: right;
            border-top: 1px solid #ddd;
            padding-top: 6px;
        }

        .no-data {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <div class="kop-inner">
            <div class="kop-text">
                <h1>SIPAKAL – Desa Kalinaun</h1>
                <p>Sistem Informasi Pelayanan dan Administrasi Desa Kalinaun</p>
                <p>Kalinaun, Kecamatan Likupang Timur, Kabupaten Minahasa Utara</p>
            </div>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="report-title">
        <h2>{{ $title }}</h2>
    </div>
    <div class="report-meta">
        Dicetak pada: {{ $date }}
    </div>

    <!-- TABEL DATA -->
    @if(count($rows) > 0)
    <table class="data-table">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- RINGKASAN -->
    <div style="margin-top: 10px; font-size: 10px; color: #555;">
        Total Data: <strong>{{ count($rows) }}</strong> baris
    </div>

    @else
    <div class="no-data">
        Tidak ada data untuk ditampilkan.
    </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        SIPAKAL – Desa Kalinaun &nbsp;|&nbsp; Dokumen ini dibuat secara otomatis oleh sistem
    </div>

</body>
</html>
