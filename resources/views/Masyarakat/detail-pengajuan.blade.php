@extends('layouts.masyarakat')

@section('title', 'Detail Pengajuan Surat')

@section('content')
<style>
    :root {
        --primary-green: #28a745;
        --primary-dark: #1f7e34;
        --light-green: #c8e6c9;
        --very-light-green: #e8f5e9;
        --text-dark: #2d5016;
        --text-gray: #666;
        --border-light: #e0e0e0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .mobile-page {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 0;
    }

    .page-header-back {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .page-header-back:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateX(-3px);
    }

    .page-header-title {
        flex: 1;
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .page-header p {
        margin: 4px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .page-content {
        padding: 15px;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-light);
        margin-bottom: 15px;
    }

    .detail-card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 15px 20px;
        margin: -20px -20px 20px -20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-card-header h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .detail-section {
        margin-bottom: 20px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-value {
        color: var(--text-gray);
        font-size: 0.95rem;
        line-height: 1.5;
        padding: 10px;
        background: var(--very-light-green);
        border-radius: 8px;
        border-left: 3px solid var(--primary-green);
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .status-timeline {
        background: var(--very-light-green);
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid var(--primary-green);
    }

    .status-item {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .status-item:last-child {
        margin-bottom: 0;
    }

    .status-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary-green);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .status-text {
        flex: 1;
    }

    .status-text-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .status-text-desc {
        font-size: 0.8rem;
        color: #999;
        margin-top: 2px;
    }

    .download-btn {
        width: 100%;
        padding: 12px 15px;
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        margin-top: 20px;
    }

    .download-btn:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .back-btn {
        width: 100%;
        padding: 12px 15px;
        background: #e0e0e0;
        color: #333;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        margin-top: 10px;
    }

    .back-btn:hover {
        background: #d0d0d0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .alert-custom {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .alert-success-custom {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .documents-list {
        list-style: none;
        padding: 0;
    }

    .documents-list li {
        padding: 12px;
        background: var(--very-light-green);
        border-radius: 8px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 3px solid var(--primary-green);
    }

    .documents-list li:last-child {
        margin-bottom: 0;
    }

    .documents-list li i {
        font-size: 18px;
        color: var(--primary-green);
        min-width: 20px;
        text-align: center;
    }

    .documents-list li a {
        color: var(--primary-green);
        text-decoration: none;
        flex: 1;
        font-size: 0.9rem;
        font-weight: 600;
        word-break: break-all;
    }

    .documents-list li a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 20px;
        color: #999;
        font-size: 0.9rem;
    }

    .empty-state i {
        font-size: 32px;
        color: #ddd;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="mobile-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>Detail Pengajuan</h1>
            <p>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</p>
        </div>
    </div>

    <div class="page-content">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Detail Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-file-alt"></i>
                <h2>Informasi Pengajuan</h2>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-heading"></i> Jenis Surat
                </div>
                <div class="detail-value">
                    {{ $pengajuan->jenisSurat->nama_surat ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-info-circle"></i> Status
                </div>
                <div style="margin-bottom: 0;">
                    @switch($pengajuan->status)
                        @case('baru')
                            <span class="badge badge-warning">Baru</span>
                            @break
                        @case('diproses')
                            <span class="badge badge-info">Diproses</span>
                            @break
                        @case('disetujui')
                            <span class="badge badge-success">Disetujui</span>
                            @break
                        @case('ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-pencil-alt"></i> Tujuan Pengajuan
                </div>
                <div class="detail-value">
                    {{ $pengajuan->keperluan ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-calendar-alt"></i> Tanggal
                </div>
                <div class="detail-value">
                    Dibuat: {{ $pengajuan->created_at->format('d M Y, H:i') }}<br>
                    Diubah: {{ $pengajuan->updated_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>

        <!-- Documents Card -->
        @if ($pengajuan->dokumen_pendukung && is_array($pengajuan->dokumen_pendukung) && count($pengajuan->dokumen_pendukung) > 0)
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-paperclip"></i>
                <h2>Dokumen Pendukung</h2>
            </div>

            <ul class="documents-list">
                @foreach ($pengajuan->dokumen_pendukung as $dokumen)
                <li>
                    <i class="fas fa-file"></i>
                    <a href="{{ asset('storage/' . $dokumen) }}" download>
                        {{ basename($dokumen) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Timeline Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-history"></i>
                <h2>Timeline Proses</h2>
            </div>

            <div class="status-timeline">
                <div class="status-item">
                    <div class="status-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="status-text">
                        <div class="status-text-title">Pengajuan Diterima</div>
                        <div class="status-text-desc">{{ $pengajuan->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                @if ($pengajuan->status !== 'baru')
                <div class="status-item">
                    <div class="status-icon" style="background: @if($pengajuan->status === 'ditolak') #dc3545 @else var(--primary-green) @endif;">
                        @if($pengajuan->status === 'ditolak')
                            <i class="fas fa-times"></i>
                        @else
                            <i class="fas fa-check"></i>
                        @endif
                    </div>
                    <div class="status-text">
                        <div class="status-text-title">
                            @switch($pengajuan->status)
                                @case('diproses')
                                    Sedang Diproses
                                    @break
                                @case('disetujui')
                                    Disetujui
                                    @break
                                @case('ditolak')
                                    Ditolak
                                    @break
                            @endswitch
                        </div>
                        <div class="status-text-desc">{{ $pengajuan->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Download Button (if approved) -->
        @if ($pengajuan->status === 'disetujui')
        <a href="{{ route('masyarakat.download-surat', $pengajuan->id) }}" class="download-btn">
            <i class="fas fa-download"></i> Unduh Surat
        </a>
        @endif

        <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
