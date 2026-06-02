@extends('layouts.masyarakat')

@section('title', 'Dashboard Masyarakat - SIPAKAL')

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

    .mobile-dashboard {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    /* ===== HEADER WELCOME ===== */
    .header-welcome {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin-bottom: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header-welcome h5 {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .header-welcome p {
        font-size: 0.9rem;
        margin: 0;
        opacity: 0.95;
    }

    /* ===== BANNER/CAROUSEL SECTION ===== */
    .banner-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
        overflow: hidden;
    }

    .carousel-container {
        position: relative;
        width: 100%;
        overflow: hidden;
        border-radius: 12px;
        background: #f0f0f0;
    }

    .carousel-wrapper {
        display: flex;
        transition: transform 0.4s ease-out;
        touch-action: pan-y;
    }

    .carousel-slide {
        min-width: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        cursor: grab;
    }

    .carousel-slide:active {
        cursor: grabbing;
    }

    .carousel-slide-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);
    }

    .carousel-slide-content {
        padding: 15px;
        background: white;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .carousel-slide-date {
        font-size: 0.75rem;
        color: #999;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .carousel-slide-title {
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

    .carousel-slide-excerpt {
        font-size: 0.8rem;
        color: #666;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .carousel-slide-link {
        font-size: 0.8rem;
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .carousel-slide-link:hover {
        color: var(--primary-dark);
        gap: 8px;
    }

    /* Carousel Controls */
    .carousel-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent);
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .carousel-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: var(--primary-green);
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .carousel-btn:hover {
        background: white;
        transform: scale(1.1);
    }

    .carousel-btn:active {
        transform: scale(0.95);
    }

    .carousel-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Carousel Indicators */
    .carousel-indicators {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
        z-index: 10;
    }

    .carousel-indicator {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-indicator.active {
        background: white;
        width: 18px;
        border-radius: 3px;
    }

    .carousel-indicator:hover {
        background: rgba(255, 255, 255, 0.8);
    }

    /* Empty State */
    .carousel-empty {
        width: 100%;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%);
        color: #999;
        text-align: center;
        border-radius: 12px;
    }

    .carousel-empty i {
        font-size: 48px;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .carousel-empty p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* ===== MENU GRID ===== */
    .menu-section {
        background: white;
        padding: 15px;
        margin-bottom: 10px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        padding: 15px 8px;
        background: var(--light-green);
        border-radius: 12px;
        color: var(--text-dark);
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .menu-item:hover {
        background: #a5d6a7;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .menu-item:active {
        transform: translateY(-1px);
    }

    .menu-item i {
        font-size: 26px;
        margin-bottom: 6px;
        color: var(--primary-green);
        transition: color 0.3s ease;
    }

    .menu-item:hover i {
        color: white;
    }

    .menu-item span {
        font-size: 0.7rem;
        font-weight: 500;
        line-height: 1.2;
    }

    /* ===== STATS SECTION ===== */
    .stats-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
    }

    .stats-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stat-card {
        background: var(--very-light-green);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid var(--primary-green);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
        transform: translateX(2px);
    }

    .stat-card-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-card-icon {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        min-width: 45px;
    }

    .stat-card-text h6 {
        margin: 0;
        font-size: 0.75rem;
        color: var(--text-gray);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card-text h3 {
        margin: 4px 0 0 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    .stat-card-arrow {
        font-size: 24px;
        color: #ddd;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-card-arrow {
        color: var(--primary-green);
        transform: translateX(3px);
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
    }

    .action-btn {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 10px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .action-btn i {
        font-size: 18px;
        min-width: 20px;
        text-align: center;
    }

    .action-btn-success {
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .action-btn-success:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .action-btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
    }

    .action-btn-info:hover {
        background: linear-gradient(135deg, #117a8b 0%, #0c5460 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }

    .action-btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #333;
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);
    }

    .action-btn-warning:hover {
        background: linear-gradient(135deg, #e0a800 0%, #c49400 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        color: white;
    }

    .action-btn:active {
        transform: translateY(0px);
    }

    /* ===== RECENT SECTION ===== */
    .recent-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
    }

    .recent-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .recent-item {
        background: var(--very-light-green);
        padding: 12px;
        margin-bottom: 8px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 3px solid var(--primary-green);
        transition: all 0.3s ease;
    }

    .recent-item:hover {
        box-shadow: 0 2px 6px rgba(40, 167, 69, 0.1);
    }

    .recent-item-left small {
        display: block;
        color: #999;
        margin-bottom: 4px;
        font-size: 0.75rem;
    }

    .recent-item-left div {
        color: var(--text-dark);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .badge-sm {
        font-size: 0.65rem;
        padding: 4px 8px;
        font-weight: 600;
        border-radius: 4px;
    }

    .view-all-link {
        display: block;
        text-align: center;
        margin-top: 12px;
    }

    .view-all-link a {
        color: var(--primary-green);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-all-link a:hover {
        color: var(--primary-dark);
    }

    /* ===== QUICK FORM SECTION ===== */
    .form-section {
        padding: 15px;
        margin-bottom: 20px;
        background: white;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-light);
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 15px 20px;
        margin: -20px -20px 20px -20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .form-card-header i {
        font-size: 1.2rem;
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

    .alert-danger-custom {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        outline: none;
    }

    .form-text {
        font-size: 0.8rem;
        color: #999;
        margin-top: 4px;
    }

    .btn-submit {
        width: 100%;
        padding: 12px 15px;
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 5px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0px);
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .text-danger {
        color: #dc3545;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        display: block;
        margin-top: 4px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 30px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 10px;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .stat-card {
            padding: 10px;
        }

        .stat-card-text h3 {
            font-size: 1.6rem;
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
    }

    @media (max-width: 576px) {
        .menu-item {
            padding: 12px 6px;
        }

        .menu-item i {
            font-size: 24px;
        }

        .menu-item span {
            font-size: 0.65rem;
        }

        .banner-img {
            height: 150px;
        }

        .action-btn {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .action-btn i {
            font-size: 16px;
        }

        .stat-card-text h3 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="mobile-dashboard">
    <!-- Header Welcome -->
    <div class="header-welcome">
        <h5><i class="fas fa-user-circle"></i> Selamat datang</h5>
        <p>{{ auth()->user()->name ?? 'Masyarakat' }}</p>
    </div>

    <!-- Banner/Carousel Section - Informasi Berita Desa -->
    <div class="banner-section">
        @if(isset($informasiTerbaru) && $informasiTerbaru->count() > 0)
        <div class="carousel-container" id="carouselContainer">
            <div class="carousel-wrapper" id="carouselWrapper">
                @foreach($informasiTerbaru as $index => $berita)
                <div class="carousel-slide" data-index="{{ $index }}">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="carousel-slide-image">
                    @else
                        <div class="carousel-slide-image" style="background: linear-gradient(135deg, var(--light-green) 0%, var(--very-light-green) 100%); display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fas fa-newspaper" style="font-size: 48px;"></i>
                        </div>
                    @endif
                    <div class="carousel-slide-content">
                        <div>
                            <div class="carousel-slide-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $berita->created_at->format('d M Y') }}
                            </div>
                            <h6 class="carousel-slide-title">{{ $berita->judul }}</h6>
                            <p class="carousel-slide-excerpt">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                        </div>
                        <a href="{{ route('masyarakat.detail-informasi', $berita->id) }}" class="carousel-slide-link">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            @if($informasiTerbaru->count() > 1)
            <div class="carousel-controls">
                <button class="carousel-btn" id="prevBtn" onclick="prevSlide()" aria-label="Slide sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="carousel-indicators" id="carouselIndicators">
                    @foreach($informasiTerbaru as $index => $berita)
                    <button class="carousel-indicator {{ $index === 0 ? 'active' : '' }}" 
                            onclick="goToSlide({{ $index }})" 
                            aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <button class="carousel-btn" id="nextBtn" onclick="nextSlide()" aria-label="Slide berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @endif
        </div>
        @else
        <div class="carousel-empty">
            <i class="fas fa-info-circle"></i>
            <p>Tidak ada berita informasi desa</p>
        </div>
        @endif
    </div>

    <!-- Menu Grid Section -->
    <div class="menu-section">
        <div class="menu-grid">
            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="menu-item" title="Pengajuan Surat">
                <i class="fas fa-file-alt"></i>
                <span>Pengajuan Surat</span>
            </a>
            <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="menu-item" title="Riwayat">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="menu-item" title="Pengaduan">
                <i class="fas fa-comments"></i>
                <span>Pengaduan</span>
            </a>
            <a href="{{ route('masyarakat.informasi-desa') }}" class="menu-item" title="Informasi">
                <i class="fas fa-info-circle"></i>
                <span>Informasi</span>
            </a>
            <a href="{{ route('masyarakat.bansos.index') }}" class="menu-item" title="Bansos">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Bansos</span>
            </a>
            <a href="{{ route('masyarakat.bansos.applications') }}" class="menu-item" title="Aplikasi">
                <i class="fas fa-check-square"></i>
                <span>Aplikasi</span>
            </a>
            <a href="{{ route('masyarakat.profil') }}" class="menu-item" title="Profil">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
            <a href="{{ route('masyarakat.notifications.index') }}" class="menu-item" title="Notifikasi">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-section">
        <div class="stats-title">
            <i class="fas fa-chart-line"></i> Statistik Anda
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-text">
                    <h6>Total Pengajuan</h6>
                    <h3>{{ $stats['total_pengajuan'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-card-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-card-text">
                    <h6>Sedang Diproses</h6>
                    <h3>{{ $stats['pengajuan_diproses'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-card-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-card-text">
                    <h6>Total Pengaduan</h6>
                    <h3>{{ $stats['total_pengaduan'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-card-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #e83e8c 0%, #c21360 100%);">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="stat-card-text">
                    <h6>Bansos Aktif</h6>
                    <h3>{{ $stats['bansos_aktif'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-card-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section">
        <a href="{{ route('masyarakat.pengajuan-surat') }}" class="action-btn action-btn-success">
            <i class="fas fa-plus-circle"></i>
            <span>Buat Pengajuan Surat Baru</span>
        </a>
        <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="action-btn action-btn-info">
            <i class="fas fa-list"></i>
            <span>Lihat Riwayat Pengajuan</span>
        </a>
        <a href="{{ route('masyarakat.pengaduan.index') }}" class="action-btn action-btn-warning">
            <i class="fas fa-megaphone"></i>
            <span>Sampaikan Pengaduan</span>
        </a>
    </div>

    <!-- Recent Pengajuan -->
    @if(isset($pengajuanTerbaru) && $pengajuanTerbaru->count() > 0)
    <div class="recent-section">
        <div class="recent-title">
            <i class="fas fa-clock"></i> Pengajuan Terbaru
        </div>
        @foreach($pengajuanTerbaru as $pengajuan)
        <div class="recent-item">
            <div class="recent-item-left">
                <small>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</small>
                <div>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</div>
            </div>
            <div>
                @if($pengajuan->status === 'diproses')
                    <span class="badge badge-sm" style="background: #fff3cd; color: #856404;">Diproses</span>
                @elseif($pengajuan->status === 'disetujui')
                    <span class="badge badge-sm" style="background: #d4edda; color: #155724;">Disetujui</span>
                @elseif($pengajuan->status === 'ditolak')
                    <span class="badge badge-sm" style="background: #f8d7da; color: #721c24;">Ditolak</span>
                @else
                    <span class="badge badge-sm" style="background: #e2e3e5; color: #383d41;">{{ ucfirst($pengajuan->status) }}</span>
                @endif
            </div>
        </div>
        @endforeach
        <div class="view-all-link">
            <a href="{{ route('masyarakat.riwayat-pengajuan') }}">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @else
    <div class="recent-section">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada pengajuan surat</p>
        </div>
    </div>
    @endif

    <!-- Quick Form -->
    <div class="form-section">
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-file-alt"></i>
                <h5>Pengajuan Cepat</h5>
            </div>

            @if(session('success'))
                <div class="alert-custom alert-success-custom">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-custom alert-danger-custom">
                    <div style="flex: 1;">
                        <div style="font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                        </div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('masyarakat.pengajuan-surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="jenis_surat_id" class="form-label">
                        <i class="fas fa-file-signature"></i> Pilih Jenis Surat
                        <span class="text-danger">*</span>
                    </label>
                    <select name="jenis_surat_id" id="jenis_surat_id" class="form-select @error('jenis_surat_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @if(isset($jenisSurat))
                            @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_surat }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('jenis_surat_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="dokumen_pendukung" class="form-label">
                        <i class="fas fa-paperclip"></i> Dokumen Persyaratan
                    </label>
                    <input type="file" class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                           id="dokumen_pendukung" name="dokumen_pendukung[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> Format: JPG, PNG, PDF. Maksimal 2MB per file
                    </div>
                    @error('dokumen_pendukung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keperluan" class="form-label">
                        <i class="fas fa-pen-fancy"></i> Tujuan Pengajuan
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="keperluan" id="keperluan" class="form-control @error('keperluan') is-invalid @enderror"
                              rows="3" placeholder="Jelaskan tujuan pengajuan surat ini..." required>{{ old('keperluan') }}</textarea>
                    <div class="form-text">Minimal 10 karakter, maksimal 500 karakter</div>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // ===== CAROUSEL FUNCTIONALITY =====
    let currentSlide = 0;
    let touchStartX = 0;
    let touchEndX = 0;
    let isAutoPlay = true;
    let autoPlayTimer = null;

    const carouselWrapper = document.getElementById('carouselWrapper');
    const carouselContainer = document.getElementById('carouselContainer');
    const slides = document.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;

    // Start carousel auto-play
    function startAutoPlay() {
        if (totalSlides > 1 && isAutoPlay) {
            autoPlayTimer = setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }, 5000); // Ganti slide setiap 5 detik
        }
    }

    // Stop carousel auto-play
    function stopAutoPlay() {
        clearInterval(autoPlayTimer);
    }

    // Update carousel position
    function updateCarousel() {
        if (carouselWrapper) {
            const offset = -currentSlide * 100;
            carouselWrapper.style.transform = `translateX(${offset}%)`;
        }

        // Update indicators
        document.querySelectorAll('.carousel-indicator').forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });

        // Update buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) prevBtn.disabled = currentSlide === 0;
        if (nextBtn) nextBtn.disabled = currentSlide === totalSlides - 1;
    }

    // Next slide
    window.nextSlide = function() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateCarousel();
            stopAutoPlay();
            startAutoPlay();
        }
    };

    // Previous slide
    window.prevSlide = function() {
        if (currentSlide > 0) {
            currentSlide--;
            updateCarousel();
            stopAutoPlay();
            startAutoPlay();
        }
    };

    // Go to specific slide
    window.goToSlide = function(index) {
        currentSlide = index;
        updateCarousel();
        stopAutoPlay();
        startAutoPlay();
    };

    // Touch support for swipe
    if (carouselContainer) {
        carouselContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoPlay();
        });

        carouselContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoPlay();
        });

        carouselContainer.addEventListener('mouseenter', () => {
            stopAutoPlay();
        });

        carouselContainer.addEventListener('mouseleave', () => {
            startAutoPlay();
        });
    }

    // Handle swipe
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next slide
                if (currentSlide < totalSlides - 1) {
                    currentSlide++;
                }
            } else {
                // Swipe right - prev slide
                if (currentSlide > 0) {
                    currentSlide--;
                }
            }
            updateCarousel();
        }
    }

    // Initialize carousel
    if (totalSlides > 0) {
        updateCarousel();
        startAutoPlay();
    }

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // ===== AUTO CLOSE ALERT =====
    document.querySelectorAll('.alert-custom').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // ===== FORM VALIDATION =====
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const jenisSurat = document.getElementById('jenis_surat_id').value;
            const keperluan = document.getElementById('keperluan').value;

            if (!jenisSurat) {
                e.preventDefault();
                alert('Pilih jenis surat terlebih dahulu');
                return false;
            }

            if (keperluan.trim().length < 10) {
                e.preventDefault();
                alert('Tujuan pengajuan minimal 10 karakter');
                return false;
            }
        });
    }
</script>

@endsection
