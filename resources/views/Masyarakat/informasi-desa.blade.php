@extends('layouts.masyarakat')

@section('title', 'Informasi Desa - SIPAKAL')

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

    .page-container {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .content-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .informasi-card {
        background: var(--very-light-green);
        border: 2px solid transparent;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .informasi-card:hover {
        border-color: var(--primary-green);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }

    .informasi-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 48px;
    }

    .informasi-content {
        padding: 12px;
    }

    .informasi-date {
        font-size: 0.75rem;
        color: #999;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .informasi-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .informasi-excerpt {
        font-size: 0.8rem;
        color: var(--text-gray);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .informasi-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: var(--primary-green);
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .informasi-link:hover {
        background: var(--primary-dark);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 1rem;
        margin: 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background: var(--light-green);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .back-btn:hover {
        background: #a5d6a7;
        transform: translateX(-3px);
    }

    @media (max-width: 576px) {
        .informasi-image {
            height: 120px;
        }

        .informasi-title {
            font-size: 0.9rem;
        }

        .informasi-excerpt {
            font-size: 0.75rem;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-info-circle"></i> Informasi Desa</h4>
        <p>Berita dan pengumuman terbaru dari desa</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.dashboard') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="section-title">
            <i class="fas fa-newspaper"></i> Berita & Pengumuman
        </div>

        @if(isset($informasis) && $informasis->count() > 0)
            @foreach($informasis as $informasi)
            <div class="informasi-card">
                @if($informasi->gambar)
                    <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="{{ $informasi->judul }}" class="informasi-image">
                @else
                    <div class="informasi-image" style="background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);">
                        <i class="fas fa-newspaper"></i>
                    </div>
                @endif
                <div class="informasi-content">
                    <div class="informasi-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $informasi->created_at->format('d M Y') }}
                    </div>
                    <h6 class="informasi-title">{{ $informasi->judul }}</h6>
                    <p class="informasi-excerpt">{{ Str::limit(strip_tags($informasi->konten), 150) }}</p>
                    <a href="{{ route('masyarakat.detail-informasi', $informasi->id) }}" class="informasi-link">
                        <i class="fas fa-arrow-right"></i> Baca Selengkapnya
                    </a>
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada informasi desa</p>
        </div>
        @endif
    </div>
</div>

@endsection
