@extends('layouts.masyarakat')

@section('title', 'Detail Informasi Desa')

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
        overflow: hidden;
    }

    .detail-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);
        margin: -20px -20px 20px -20px;
        border-radius: 12px 12px 0 0;
    }

    .detail-image-empty {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -20px -20px 20px -20px;
        border-radius: 12px 12px 0 0;
        color: #999;
    }

    .detail-image-empty i {
        font-size: 64px;
    }

    .detail-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .detail-card-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
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
        font-size: 0.85rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #999;
    }

    .detail-value {
        color: var(--text-gray);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .content-text {
        color: var(--text-gray);
        font-size: 0.95rem;
        line-height: 1.8;
        text-align: justify;
    }

    .content-text p {
        margin-bottom: 15px;
    }

    .content-text p:last-child {
        margin-bottom: 0;
    }

    .meta-info {
        display: flex;
        gap: 20px;
        padding: 15px;
        background: var(--very-light-green);
        border-radius: 8px;
        border-left: 3px solid var(--primary-green);
        flex-wrap: wrap;
    }

    .meta-item {
        flex: 1;
        min-width: 150px;
    }

    .meta-item-label {
        font-size: 0.75rem;
        color: #999;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .meta-item-value {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.9rem;
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
        margin-top: 20px;
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

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.3rem;
        }

        .detail-image {
            height: 200px;
        }

        .detail-image-empty {
            height: 200px;
        }

        .meta-info {
            flex-direction: column;
        }

        .meta-item {
            min-width: auto;
        }
    }
</style>

<div class="mobile-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('masyarakat.informasi-desa') }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>Informasi Desa</h1>
            <p>Berita & Pengumuman</p>
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
            <!-- Image -->
            @if ($informasi->gambar)
                <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="{{ $informasi->judul }}" class="detail-image">
            @else
                <div class="detail-image-empty">
                    <i class="fas fa-image"></i>
                </div>
            @endif

            <!-- Header -->
            <div class="detail-card-header">
                <h2>{{ $informasi->judul }}</h2>
            </div>

            <!-- Meta Info -->
            <div class="meta-info">
                <div class="meta-item">
                    <div class="meta-item-label">
                        <i class="fas fa-calendar-alt"></i> Tanggal Posting
                    </div>
                    <div class="meta-item-value">
                        {{ $informasi->created_at->format('d M Y') }}
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-item-label">
                        <i class="fas fa-clock"></i> Waktu
                    </div>
                    <div class="meta-item-value">
                        {{ $informasi->created_at->format('H:i') }}
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-item-label">
                        <i class="fas fa-user"></i> Diposting Oleh
                    </div>
                    <div class="meta-item-value">
                        Admin
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="detail-section" style="margin-top: 20px;">
                <div class="content-text">
                    {!! nl2br(e($informasi->konten)) !!}
                </div>
            </div>
        </div>

        <!-- Update Info Card -->
        @if ($informasi->updated_at && $informasi->updated_at != $informasi->created_at)
        <div class="detail-card" style="padding: 15px; background: var(--very-light-green); border-left: 3px solid var(--primary-green);">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; color: var(--text-dark);">
                <i class="fas fa-info-circle"></i>
                <span>
                    <strong>Terakhir diperbarui:</strong> {{ $informasi->updated_at->format('d M Y, H:i') }}
                </span>
            </div>
        </div>
        @endif

        <a href="{{ route('masyarakat.informasi-desa') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
