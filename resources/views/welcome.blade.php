@extends('layouts.app')

@section('title', 'Beranda - SIPAKAL')

@section('content')
<style>
    :root {
        --primary-green: #28a745;
        --primary-dark: #1f7e34;
        --light-green: #c8e6c9;
        --very-light-green: #e8f5e9;
        --text-dark: #2d5016;
    }

    .service-card-link {
        display: inline-block;
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .service-card-link:hover {
        color: var(--primary-dark);
        transform: translateX(5px);
    }

    .card-premium {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(40, 167, 69, 0.15);
    }
</style>

<!-- Hero Section -->
<section class="hero-slider">
    <div class="hero-slide" style="background-image: url('{{ asset('img/pantaipaal.jpg') }}');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="badge bg-primary-premium mb-3 px-3 py-2" style="background-color: var(--primary-green);">Selamat Datang di </span>
                <h1 class="hero-title">SISTEM PELAYANAN ADMINISTRASI<br>KALINAUN</h1>
                <p class="hero-subtitle">Membantu Masyarakat untuk mewujudkan kehidupan yang sejahtera</p>
                <div class="d-grid gap-3 d-md-flex justify-content-md-start">
                    <a href="#layanan" class="btn btn-primary-premium shadow-lg" style="background-color: var(--primary-green); border-color: var(--primary-green);">Layanan Publik</a>
                    <!-- <a href="#profil" class="btn btn-outline-light rounded-pill px-4 fw-bold border-2">Tentang Desa</a> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="layanan" class="py-5">
    <div class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-lg-6 mx-auto">
                <h6 class="fw-bold text-uppercase mb-2" style="color: var(--primary-green);">Layanan Kami</h6>
                <h2 class="fw-bold display-6">Kemudahan Akses Informasi</h2>
                <div class="mx-auto mt-3 mb-4" style="width: 60px; height: 4px; background: linear-gradient(90deg, var(--primary-green) 0%, var(--light-green) 100%);"></div>
                <p class="text-muted">Kami menyediakan berbagai layanan digital untuk mempermudah warga dalam mengurus administrasi dan mendapatkan informasi terbaru.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Persuratan Online -->
            <div class="col-md-4">
                <div class="card-premium p-4 h-100" style="border-radius: 12px; background: white;">
                    <div class="card-icon" style="background: linear-gradient(135deg, var(--very-light-green) 0%, var(--light-green) 100%); color: var(--primary-green); padding: 20px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; width: 60px; height: 60px;">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--text-dark);">Persuratan Online</h4>
                    <p class="text-muted">Ajukan permohonan surat keterangan domisili, usaha, dan lainnya secara online tanpa harus antre.</p>
                    @auth
                        @if(auth()->user()->role === 'masyarakat')
                            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="service-card-link">
                                Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <p class="text-muted small">Silakan login sebagai masyarakat untuk mengakses layanan ini</p>
                        @endif
                    @else
                        <p class="text-muted small mb-3">Silakan <a href="{{ route('masyarakat-login') }}" style="color: var(--primary-green); font-weight: 600;">login</a> untuk mengakses layanan ini</p>
                    @endauth
                </div>
            </div>

            <!-- Informasi Publik -->
            <div class="col-md-4">
                <div class="card-premium p-4 h-100" style="border-radius: 12px; background: white;">
                    <div class="card-icon" style="background: linear-gradient(135deg, #fff7ed 0%, #ffe8cc 100%); color: #f59e0b; padding: 20px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; width: 60px; height: 60px;">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--text-dark);">Informasi Publik</h4>
                    <p class="text-muted">Dapatkan update berita desa, pengumuman penting, dan agenda kegiatan secara real-time.</p>
                    @auth
                        @if(auth()->user()->role === 'masyarakat')
                            <a href="{{ route('masyarakat.informasi-desa') }}" class="service-card-link">
                                Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <p class="text-muted small">Silakan login sebagai masyarakat untuk mengakses layanan ini</p>
                        @endif
                    @else
                        <p class="text-muted small mb-3">Silakan <a href="{{ route('masyarakat-login') }}" style="color: var(--primary-green); font-weight: 600;">login</a> untuk mengakses layanan ini</p>
                    @endauth
                </div>
            </div>

            <!-- Layanan Pengaduan -->
            <div class="col-md-4">
                <div class="card-premium p-4 h-100" style="border-radius: 12px; background: white;">
                    <div class="card-icon" style="background: linear-gradient(135deg, #f0f9ff 0%, #cce5ff 100%); color: #0ea5e9; padding: 20px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; width: 60px; height: 60px;">
                        <i class="fas fa-hand-holding-heart fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--text-dark);">Layanan Pengaduan</h4>
                    <p class="text-muted">Sampaikan aspirasi, keluhan, atau saran Anda demi kemajuan Desa Kalinaun yang lebih baik.</p>
                    @auth
                        @if(auth()->user()->role === 'masyarakat')
                            <a href="{{ route('masyarakat.pengaduan.index') }}" class="service-card-link">
                                Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <p class="text-muted small">Silakan login sebagai masyarakat untuk mengakses layanan ini</p>
                        @endif
                    @else
                        <p class="text-muted small mb-3">Silakan <a href="{{ route('masyarakat-login') }}" style="color: var(--primary-green); font-weight: 600;">login</a> untuk mengakses layanan ini</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);">
    <div class="container py-4 text-center">
        <h2 class="text-white fw-bold mb-4">Mari Bangun Desa Bersama Kami</h2>
        <p class="text-white-50 mb-5 max-w-2xl mx-auto">Suara Anda sangat berarti bagi kami. Gunakan fitur layanan mandiri untuk berinteraksi langsung dengan sistem informasi desa.</p>
        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
            @guest
                <a href="{{ route('masyarakat-login') }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary shadow-lg" style="color: var(--primary-green) !important;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-warning rounded-pill px-5 py-3 fw-bold shadow-lg">Daftar Akun Baru</a>
            @else
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary shadow-lg" style="color: var(--primary-green) !important;">Kembali ke Dashboard</a>
            @endguest
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush