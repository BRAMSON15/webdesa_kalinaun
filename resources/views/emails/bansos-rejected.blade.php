<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .footer { background: #f0f0f0; padding: 10px; text-align: center; font-size: 12px; border-radius: 0 0 5px 5px; }
        .info-row { margin: 10px 0; }
        .label { font-weight: bold; color: #555; }
        .value { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>❌ Pemberitahuan Status Pengajuan Bansos</h2>
        </div>
        <div class="content">
            <p>Yth. {{ $user->name }},</p>
            
            <p>Kami menginformasikan bahwa pengajuan Anda untuk program bantuan sosial <strong>TIDAK DAPAT DISETUJUI</strong>.</p>
            
            <div class="info-row">
                <span class="label">Program:</span>
                <span class="value">{{ $bansos->nama_bansos }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value">Ditolak</span>
            </div>
            
            @if($penerima->alasan_penolakan)
            <div class="info-row">
                <span class="label">Alasan:</span>
                <span class="value">{{ $penerima->alasan_penolakan }}</span>
            </div>
            @endif
            
            <p style="margin-top: 20px;">Anda dapat mendaftar kembali pada program bantuan sosial lainnya yang sesuai dengan kriteria. Untuk informasi lebih lanjut, silakan hubungi kantor desa.</p>
            
            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                Terima kasih atas pengertiannya,<br>
                <strong>Sistem Informasi Desa</strong>
            </p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
