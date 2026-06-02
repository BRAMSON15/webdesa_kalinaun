@extends('layouts.masyarakat')

@section('title', 'Bantuan Sosial - SIPAKAL')

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

    .bansos-card {
        background: var(--very-light-green);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .bansos-card:hover {
        border-color: var(--primary-green);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }

    .bansos-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .bansos-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        flex: 1;
    }

    .bansos-status {
        font-size: 0.65rem;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: 600;
        background: #d4edda;
        color: #155724;
        text-align: center;
        min-width: 80px;
    }

    .bansos-desc {
        font-size: 0.8rem;
        color: var(--text-gray);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .bansos-quota {
        background: white;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .quota-label {
        font-size: 0.75rem;
        color: var(--text-gray);
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-green) 0%, #20c997 100%);
        border-radius: 4px;
    }

    .bansos-footer {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-apply {
        flex: 1;
        padding: 10px 15px;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-apply:hover {
        background: var(--primary-dark);
    }

    .btn-detail {
        flex: 1;
        padding: 10px 15px;
        background: #17a2b8;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-detail:hover {
        background: #117a8b;
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
        .bansos-footer {
            flex-direction: column;
        }

        .btn-apply, .btn-detail {
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-hand-holding-heart"></i> Bantuan Sosial</h4>
        <p>Lihat dan daftar program bantuan sosial yang tersedia</p>
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
            <i class="fas fa-list"></i> Program Bantuan Tersedia
        </div>

        @if(isset($bansos) && $bansos->count() > 0)
            @foreach($bansos as $program)
            <div class="bansos-card">
                <div class="bansos-header">
                    <div class="bansos-title">{{ $program->nama_program }}</div>
                    <span class="bansos-status">{{ $program->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
                <p class="bansos-desc">{{ Str::limit($program->deskripsi, 100) }}</p>
                
                <div class="bansos-quota">
                    <div class="quota-label">
                        <span>Kuota Tersedia</span>
                        <strong>{{ $program->kuota_tersisa ?? 0 }}/{{ $program->kuota_total ?? 0 }}</strong>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ ($program->kuota_tersisa ?? 0) / ($program->kuota_total ?? 1) * 100 }}%"></div>
                    </div>
                </div>

                <div class="bansos-footer">
                    <a href="{{ route('masyarakat.bansos.show', $program->id) }}" class="btn-detail">
                        <i class="fas fa-info-circle"></i> Detail
                    </a>
                    <form action="{{ route('masyarakat.bansos.apply', $program->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn-apply" style="width: 100%;">
                            <i class="fas fa-check-circle"></i> Daftar
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada program bantuan tersedia saat ini</p>
        </div>
        @endif
    </div>
</div>

@endsection
