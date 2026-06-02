@extends('layouts.masyarakat')

@section('title', 'Detail Program Bansos')

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

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .progress-section {
        margin-bottom: 20px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .progress-header-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .progress-header-value {
        font-size: 0.85rem;
        color: var(--text-gray);
        font-weight: 600;
    }

    .progress-bar {
        width: 100%;
        height: 24px;
        background: #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-green) 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        transition: width 0.3s ease;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .stat-item {
        background: var(--very-light-green);
        padding: 12px;
        border-radius: 8px;
        border-left: 3px solid var(--primary-green);
        text-align: center;
    }

    .stat-item-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 4px;
    }

    .stat-item-label {
        font-size: 0.75rem;
        color: var(--text-gray);
        font-weight: 600;
        text-transform: uppercase;
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

    .alert-info-custom {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    .alert-success-custom {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .requirements-list {
        list-style: none;
        padding: 0;
    }

    .requirements-list li {
        padding: 8px 0;
        padding-left: 24px;
        position: relative;
        font-size: 0.9rem;
        color: var(--text-gray);
        line-height: 1.4;
    }

    .requirements-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--primary-green);
        font-weight: bold;
        font-size: 1.1rem;
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

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="mobile-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('masyarakat.bansos.index') }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>{{ $bansos->nama_bansos }}</h1>
            <p>Program Bantuan Sosial</p>
        </div>
    </div>

    <div class="page-content">
        <!-- Status Alert -->
        @if (session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-custom" style="background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($sudahMendaftar)
            <div class="alert-custom alert-info-custom">
                <i class="fas fa-info-circle"></i>
                <span>Anda sudah mendaftar untuk program ini</span>
            </div>
        @endif

        <!-- Main Detail Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-hand-holding-heart"></i>
                <h2>Informasi Program</h2>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-align-left"></i> Deskripsi
                </div>
                <div class="detail-value">
                    {{ nl2br($bansos->deskripsi) }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-calendar-alt"></i> Periode
                </div>
                <div class="detail-value">
                    {{ \Carbon\Carbon::parse($bansos->tanggal_mulai)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($bansos->tanggal_selesai)->format('d M Y') }}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-label">
                    <i class="fas fa-coins"></i> Nominal
                </div>
                <div class="detail-value">
                    Rp{{ number_format($bansos->nominal, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Quota Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-chart-pie"></i>
                <h2>Kuota Penerima</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-item-value">{{ $bansos->kuota ?? 0 }}</div>
                    <div class="stat-item-label">Total Kuota</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $bansos->penerimaBansos()->whereIn('status', ['disetujui', 'diterima'])->count() ?? 0 }}</div>
                    <div class="stat-item-label">Sudah Diterima</div>
                </div>
            </div>

            <div class="progress-section" style="margin-top: 20px;">
                <div class="progress-header">
                    <span class="progress-header-title">Persentase Penerima</span>
                    <span class="progress-header-value">
                        {{ $bansos->kuota > 0 ? round(($bansos->penerimaBansos()->whereIn('status', ['disetujui', 'diterima'])->count() / $bansos->kuota) * 100) : 0 }}%
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $bansos->kuota > 0 ? min(($bansos->penerimaBansos()->whereIn('status', ['disetujui', 'diterima'])->count() / $bansos->kuota) * 100, 100) : 0 }}%;">
                        @if ($bansos->kuota > 0 && ($bansos->penerimaBansos()->whereIn('status', ['disetujui', 'diterima'])->count() / $bansos->kuota) * 100 >= 20)
                            {{ round(($bansos->penerimaBansos()->whereIn('status', ['disetujui', 'diterima'])->count() / $bansos->kuota) * 100) }}%
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Requirements Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-list-check"></i>
                <h2>Syarat & Ketentuan</h2>
            </div>

            <div class="detail-section">
                @if ($bansos->persyaratan)
                    <ul class="requirements-list">
                        @foreach (explode("\n", $bansos->persyaratan) as $req)
                            @if (trim($req))
                                <li>{{ trim($req) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div style="text-align: center; color: #999; padding: 20px;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px;"></i>
                        <p>Tidak ada syarat tambahan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            @if (!$sudahMendaftar)
            <form action="{{ route('masyarakat.bansos.apply', $bansos) }}" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-check-circle"></i> Daftar Sekarang
                </button>
            </form>
            @else
            <a href="{{ route('masyarakat.bansos.applications') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Lihat Pendaftaran
            </a>
            @endif
            <a href="{{ route('masyarakat.bansos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
