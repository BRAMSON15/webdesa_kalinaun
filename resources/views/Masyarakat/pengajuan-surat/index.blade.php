@extends('layouts.masyarakat')

@section('title', 'Pengajuan Surat - SIPAKAL')

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
        border-radius: 8px;
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

    .jenis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }

    .jenis-card {
        background: var(--very-light-green);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        color: var(--text-dark);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .jenis-card:hover {
        border-color: var(--primary-green);
        background: #d4edda;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        transform: translateY(-3px);
    }

    .jenis-card i {
        font-size: 32px;
        color: var(--primary-green);
        margin-bottom: 10px;
    }

    .jenis-card h6 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 600;
        line-height: 1.3;
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

    @media (max-width: 768px) {
        .jenis-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .jenis-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-header h4 {
            font-size: 1.1rem;
        }

        .jenis-card i {
            font-size: 28px;
        }

        .jenis-card h6 {
            font-size: 0.75rem;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-file-alt"></i> Pilih Jenis Surat</h4>
        <p>Silakan pilih jenis surat yang ingin Anda ajukan</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.dashboard') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        @if(isset($jenisSurats) && $jenisSurats->count() > 0)
            <div class="section-title">
                <i class="fas fa-list"></i> Daftar Jenis Surat
            </div>
            <div class="jenis-grid">
                @foreach($jenisSurats as $jenis)
                <a href="{{ route('masyarakat.pengajuan-surat.create', $jenis->id) }}" class="jenis-card">
                    <i class="fas fa-file-contract"></i>
                    <h6>{{ $jenis->nama_surat }}</h6>
                </a>
                @endforeach
            </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada jenis surat yang tersedia</p>
        </div>
        @endif
    </div>
</div>

@endsection
