@extends('layouts.app')

@section('title', 'Beranda - Website Resmi Desa Kalinaun')

@section('content')
<!-- Hero Section -->
<section class="hero-slider">
    <div class="hero-slide" style="background-image: url('{{ asset('img/pantaipaal.jpg') }}');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="badge bg-primary-premium mb-3 px-3 py-2" style="background-color: var(--primary-color);">Selamat Datang di </span>
                <h1 class="hero-title">SISTEM PELAYANAN ADMINISTRASI<br>KALINAUN</h1>
                <p class="hero-subtitle">Membantu Masyarakat unutuk mewujudkan kehidupan yang sejahtera</p>
                <div class="d-flex gap-3">
                    <a href="#layanan" class="btn btn-primary-premium shadow-lg">Layanan Publik</a>
                    <a href="#profil" class="btn btn-outline-light rounded-pill px-4 fw-bold border-2">Tentang Desa</a>
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
                <h6 class="text-primary fw-bold text-uppercase mb-2">Layanan Kami</h6>
                <h2 class="fw-bold display-6">Kemudahan Akses Informasi</h2>
                <div class="mx-auto mt-3 mb-4" style="width: 60px; height: 4px; background-color: var(--primary-color);"></div>
                <p class="text-muted">Kami menyediakan berbagai layanan digital untuk mempermudah warga dalam mengurus administrasi dan mendapatkan informasi terbaru.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-premium p-4 h-100">
                    <div class="card-icon">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Persuratan Online</h4>
                    <p class="text-muted">Ajukan permohonan surat keterangan domisili, usaha, dan lainnya secara online tanpa harus antre.</p>
                    <a href="#" class="text-primary fw-bold text-decoration-none">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-premium p-4 h-100">
                    <div class="card-icon" style="background-color: #fff7ed; color: #f59e0b;">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Informasi Publik</h4>
                    <p class="text-muted">Dapatkan update berita desa, pengumuman penting, dan agenda kegiatan secara real-time.</p>
                    <a href="#" class="text-primary fw-bold text-decoration-none">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-premium p-4 h-100">
                    <div class="card-icon" style="background-color: #f0f9ff; color: #0ea5e9;">
                        <i class="fas fa-hand-holding-heart fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Layanan Pengaduan</h4>
                    <p class="text-muted">Sampaikan aspirasi, keluhan, atau saran Anda demi kemajuan Desa Kalinaun yang lebih baik.</p>
                    <a href="#" class="text-primary fw-bold text-decoration-none">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
    <div class="container py-4 text-center">
        <h2 class="text-white fw-bold mb-4">Mari Bangun Desa Bersama Kami</h2>
        <p class="text-white-50 mb-5 max-w-2xl mx-auto">Suara Anda sangat berarti bagi kami. Gunakan fitur layanan mandiri untuk berinteraksi langsung dengan sistem informasi desa.</p>
        <div class="d-flex justify-content-center gap-3">
            @guest
                <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary shadow-lg">Daftar Akun Sekarang</a>
            @else
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary shadow-lg">Kembali ke Dashboard</a>
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