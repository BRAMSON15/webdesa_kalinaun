@extends('layouts.app')

@section('title', 'Selamat Datang - Sistem Informasi Desa')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section with Background Image -->
    <div class="hero-section text-white d-flex align-items-center" style="min-height: 85vh; position: relative;">
        <!-- Background Overlay -->
        <div class="overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(135deg, rgba(46, 204, 113, 0.85) 0%, rgba(39, 174, 96, 0.9) 100%); z-index: 1;"></div>
        
        <div class="container position-relative z-index-2 w-100" style="z-index: 2;">
            <div class="row text-center text-md-start align-items-center">
                <div class="col-md-7 mb-4 mb-md-0">
                    <div class="p-4 rounded" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                        <h1 class="display-4 fw-bold mb-3 d-flex align-items-center justify-content-center justify-content-md-start" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="80" class="me-3">
                            Sistem Informasi Desa Kalinaun
                        </h1>
                        <p class="lead mb-4" style="font-size: 1.25rem;">Lebih Cepat, Mudah, dan Transparan. Mewujudkan tata kelola desa digital terintegrasi untuk masyarakat cerdas nan modern.</p>
                        @guest
                        <div class="mt-4 mt-md-5">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg me-3 fw-bold shadow" style="color: #27ae60; border-radius: 50px; padding: 12px 30px; transition: transform 0.3s;">
                                <i class="fas fa-sign-in-alt"></i> Masuk Sistem
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-warning btn-lg fw-bold shadow text-dark mt-3 mt-md-0" style="background-color: #f1c40f; border-color: #f1c40f; border-radius: 50px; padding: 12px 30px; transition: transform 0.3s;">
                                <i class="fas fa-user-plus"></i> Daftar Akun
                            </a>
                        </div>
                        @else
                        <div class="mt-4 mt-md-5">
                            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-warning btn-lg fw-bold shadow text-dark" style="background-color: #f1c40f; border-color: #f1c40f; border-radius: 50px; padding: 12px 30px; transition: transform 0.3s;">
                                <i class="fas fa-arrow-right"></i> Kembali ke Dashboard
                            </a>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 pt-3">
    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #2c3e50; position: relative; display: inline-block;">Layanan Cerdas Kami
                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 50px; height: 3px; background-color: #2ecc71;"></span>
                </h2>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="icon-circle mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(46, 204, 113, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-alt fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Pengajuan Surat Online</h5>
                    <p class="text-muted">Ajukan berbagai jenis surat keterangan secara online tanpa perlu jauh-jauh datang ke kantor desa.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm hover-card" style="transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;">
                <div class="card-body p-4">
                    <div class="icon-circle mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(241, 196, 15, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bolt fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Proses Validasi Cepat</h5>
                    <p class="text-muted">Setiap pengajuan dieksekusi secepat kilat dengan sistem notifikasi berlapis antara Anda dan Kades.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="icon-circle mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(52, 152, 219, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bullhorn fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Laporan & Pengaduan</h5>
                    <p class="text-muted">Kanal terpadu untuk menyalurkan keluhan, saran, dan ide cemerlang untuk mengembangkan desa tercinta.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jenis Surat Section -->
    <div class="row mb-5 pb-4">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #2c3e50; position: relative; display: inline-block;">Katalog Surat Desa
                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 50px; height: 3px; background-color: #2ecc71;"></span>
                </h2>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #2ecc71 !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <i class="fas fa-home fa-2x text-success me-4"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Surat Keterangan Domisili</h5>
                        <p class="text-muted mb-0 small">Menjelaskan status domisili resmi kependudukan warga</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #f1c40f !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <i class="fas fa-briefcase fa-2x text-warning me-4"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Surat Keterangan Usaha</h5>
                        <p class="text-muted mb-0 small">Bukti izin dan status kepemilikan bisnis rumahan/UMKM</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #e74c3c !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <i class="fas fa-hand-holding-heart fa-2x text-danger me-4"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Surat Keterangan Tidak Mampu</h5>
                        <p class="text-muted mb-0 small">Bantuan birokrasi bagi kelompok penerima fasilitas sosial</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #9b59b6 !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <i class="fas fa-heart fa-2x text-purple me-4" style="color: #9b59b6;"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Surat Pengantar Nikah</h5>
                        <p class="text-muted mb-0 small">Keperluan perizinan administrasi lembaga KUA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 text-white" style="background: linear-gradient(135deg, #27ae60 0%, #1abc9c 100%); border-radius: 20px; box-shadow: 0 15px 30px rgba(39, 174, 96, 0.3);">
                <div class="card-body p-md-5 text-center">
                    <h3 class="fw-bold mb-3">Butuh Bantuan Mendesak?</h3>
                    <p class="mb-5" style="opacity: 0.9;">Tim pelayanan masyarakat desa Kalinaun siap siaga membalas pertanyaan Anda di jam kerja.</p>
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-success shadow" style="width: 60px; height: 60px;">
                                <i class="fas fa-phone fa-lg"></i>
                            </div>
                            <p class="mb-1 fw-bold">Telepon Darurat</p>
                            <p class="small mb-0" style="opacity: 0.8;">0811-2233-4455</p>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-success shadow" style="width: 60px; height: 60px;">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <p class="mb-1 fw-bold">Pesan Email</p>
                            <p class="small mb-0" style="opacity: 0.8;">layanan@kalinaun.desa.id</p>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-success shadow" style="width: 60px; height: 60px;">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <p class="mb-1 fw-bold">Balai Pertemuan</p>
                            <p class="small mb-0" style="opacity: 0.8;">Jl. Pantai Paal No. 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.hero-section {
    background-image: url('{{ asset('img/pantaipaal.jpg') }}');
    background-size: cover;
    background-position: center bottom;
    background-attachment: fixed;
}
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.btn:hover {
    transform: scale(1.05);
}
</style>
@endpush
@endsection