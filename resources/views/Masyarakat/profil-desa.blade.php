@extends('layouts.app')

@section('title', 'Profil Desa - Website Resmi Desa Kalinaun')

@section('content')
<!-- Page Header -->
<div class="py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Profil Desa Kalinaun</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil Desa</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-premium p-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active text-start mb-2" id="v-pills-sejarah-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sejarah" type="button" role="tab">
                            <i class="fas fa-history me-2"></i> Sejarah Desa
                        </button>
                        <button class="nav-link text-start mb-2" id="v-pills-visi-tab" data-bs-toggle="pill" data-bs-target="#v-pills-visi" type="button" role="tab">
                            <i class="fas fa-bullseye me-2"></i> Visi & Misi
                        </button>
                        <button class="nav-link text-start mb-2" id="v-pills-geografis-tab" data-bs-toggle="pill" data-bs-target="#v-pills-geografis" type="button" role="tab">
                            <i class="fas fa-map-marked-alt me-2"></i> Geografis
                        </button>
                        <button class="nav-link text-start" id="v-pills-struktur-tab" data-bs-toggle="pill" data-bs-target="#v-pills-struktur" type="button" role="tab">
                            <i class="fas fa-users me-2"></i> Struktur Organisasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Sejarah -->
                <div class="tab-pane fade show active" id="v-pills-sejarah" role="tabpanel">
                    <div class="card-premium p-4 p-md-5">
                        <h2 class="fw-bold mb-4">Sejarah Desa Kalinaun</h2>
                        <img src="{{ asset('img/pantaipaal.jpg') }}" class="img-fluid rounded-4 mb-4 shadow-sm" alt="Sejarah">
                        <div class="lead-text mb-4">
                            {!! $profil->sejarah ?? 'Desa Kalinaun merupakan salah satu desa yang terletak di pesisir Pantai Paal, Kecamatan Likupang Timur, Kabupaten Minahasa Utara.' !!}
                        </div>
                        <p>Informasi lebih lanjut mengenai asal-usul dan perkembangan Desa Kalinaun akan terus diperbarui melalui sistem informasi ini.</p>
                    </div>
                </div>

                <!-- Visi Misi -->
                <div class="tab-pane fade" id="v-pills-visi" role="tabpanel">
                    <div class="card-premium p-4 p-md-5">
                        <h2 class="fw-bold mb-4 text-center">Visi & Misi</h2>
                        
                        <div class="mb-5">
                            <h4 class="text-primary fw-bold text-center mb-3">VISI</h4>
                            <div class="p-4 bg-light rounded-4 text-center italic" style="font-size: 1.25rem; font-style: italic;">
                                "{{ $profil->visi ?? 'Mewujudkan Desa Kalinaun yang Mandiri, Sejahtera, dan Berdaya Saing melalui Tata Kelola yang Transparan.' }}"
                            </div>
                        </div>

                        <div>
                            <h4 class="text-primary fw-bold mb-3">MISI</h4>
                            <div class="list-misi">
                                {!! $profil->misi ?? '<ul><li>Meningkatkan kualitas pelayanan publik.</li><li>Membangun infrastruktur desa yang berkelanjutan.</li><li>Memberdayakan ekonomi kerakyatan melalui potensi lokal.</li></ul>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Geografis -->
                <div class="tab-pane fade" id="v-pills-geografis" role="tabpanel">
                    <div class="card-premium p-4 p-md-5">
                        <h2 class="fw-bold mb-4">Letak Geografis</h2>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4">
                                    <h6 class="fw-bold text-muted small text-uppercase">Batas Utara</h6>
                                    <p class="mb-0 fw-bold">Laut Sulawesi</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4">
                                    <h6 class="fw-bold text-muted small text-uppercase">Batas Selatan</h6>
                                    <p class="mb-0 fw-bold">Desa Likupang</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4">
                                    <h6 class="fw-bold text-muted small text-uppercase">Batas Timur</h6>
                                    <p class="mb-0 fw-bold">Desa Marinsow</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-4">
                                    <h6 class="fw-bold text-muted small text-uppercase">Batas Barat</h6>
                                    <p class="mb-0 fw-bold">Desa Pulisan</p>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">{!! $profil->geografis ?? 'Desa Kalinaun memiliki luas wilayah yang didominasi oleh perbukitan dan pesisir pantai.' !!}</p>
                    </div>
                </div>

                <!-- Struktur -->
                <div class="tab-pane fade" id="v-pills-struktur" role="tabpanel">
                    <div class="card-premium p-4 p-md-5">
                        <h2 class="fw-bold mb-4 text-center">Struktur Organisasi</h2>
                        <div class="text-center py-5">
                            <i class="fas fa-sitemap fa-5x text-muted opacity-25 mb-4"></i>
                            <p class="text-muted">Bagan Struktur Organisasi Desa Kalinaun sedang dalam proses pembaruan data.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: var(--text-dark);
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: var(--primary-light);
        color: var(--primary-dark);
    }
    .list-misi ul {
        padding-left: 20px;
    }
    .list-misi li {
        margin-bottom: 10px;
        font-size: 1.1rem;
    }
</style>
@endsection
