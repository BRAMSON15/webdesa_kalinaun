@extends('layouts.masyarakat')

@section('title', 'Detail Pengaduan')

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

    .badge-primary {
        background: #cfe2ff;
        color: #084298;
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

    .status-text-time {
        font-size: 0.8rem;
        color: #999;
        margin-top: 2px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        flex: 1;
        padding: 12px 15px;
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
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-secondary {
        background: #e0e0e0;
        color: #333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
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

    .alert-info-custom {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
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

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="mobile-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('masyarakat.pengaduan.index') }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>Detail Pengaduan</h1>
            <p>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
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
                <h2>{{ $pengaduan->judul }}</h2>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-info-circle"></i> Status
                </div>
                <div style="margin-bottom: 15px;">
                    @switch($pengaduan->status)
                        @case('baru')
                            <span class="badge badge-warning">Baru</span>
                            @break
                        @case('diproses')
                            <span class="badge badge-info">Diproses</span>
                            @break
                        @case('selesai')
                            <span class="badge badge-success">Selesai</span>
                            @break
                        @case('ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-tag"></i> Kategori
                </div>
                <div class="detail-value">
                    @switch($pengaduan->kategori)
                        @case('layanan')
                            Layanan Publik
                            @break
                        @case('infrastruktur')
                            Infrastruktur
                            @break
                        @case('kesehatan')
                            Kesehatan
                            @break
                        @case('pendidikan')
                            Pendidikan
                            @break
                        @case('lainnya')
                            Lainnya
                            @break
                        @default
                            {{ ucfirst($pengaduan->kategori) }}
                    @endswitch
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-align-left"></i> Deskripsi
                </div>
                <div class="detail-value">
                    {{ nl2br($pengaduan->deskripsi) }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-calendar-alt"></i> Tanggal
                </div>
                <div class="detail-value">
                    Dibuat: {{ $pengaduan->created_at->format('d M Y, H:i') }}<br>
                    Diubah: {{ $pengaduan->updated_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>

        <!-- Informasi Pengaduan Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-chart-bar"></i>
                <h2>Informasi Tambahan</h2>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-hashtag"></i> ID Pengaduan
                </div>
                <div class="detail-value">
                    #{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-eye"></i> Status Visibilitas
                </div>
                <div style="margin-bottom: 0;">
                    <span class="badge badge-primary">Publik</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            @if($pengaduan->status === 'baru')
            <a href="{{ route('masyarakat.pengaduan.edit', $pengaduan) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
