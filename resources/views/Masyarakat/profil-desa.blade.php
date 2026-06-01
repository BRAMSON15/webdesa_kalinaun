@extends('layouts.masyarakat')

@section('title', 'Profil Desa - Website Resmi Desa Kalinaun')

@section('content')
<div>
    <!-- Page Header -->
    <div class="py-4 bg-light border-bottom rounded-4 mb-4">
        <div class="container text-center">
            <h2 class="fw-bold mb-2">Profil Desa Kalinaun</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil Desa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 20px; z-index: 10;">
                <div class="card shadow-sm p-3">
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
                    <div class="card shadow-sm p-4">
                        <h3 class="fw-bold mb-4">Sejarah Desa Kalinaun</h3>
                        <img src="{{ asset('img/pantaipaal.jpg') }}" class="img-fluid rounded-4 mb-4 shadow-sm" alt="Sejarah">
                        <div class="lead mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                            {!! $profil->sejarah ?? 'Desa Kalinaun merupakan salah satu desa yang terletak di pesisir Pantai Paal, Kecamatan Likupang Timur, Kabupaten Minahasa Utara.' !!}
                        </div>
                        <p class="text-muted">Informasi lebih lanjut mengenai asal-usul dan perkembangan Desa Kalinaun akan terus diperbarui melalui sistem informasi ini.</p>
                    </div>
                </div>

                <!-- Visi Misi -->
                <div class="tab-pane fade" id="v-pills-visi" role="tabpanel">
                    <div class="card shadow-sm p-4">
                        <h3 class="fw-bold mb-4 text-center">Visi & Misi</h3>
                        
                        <div class="mb-5">
                            <h5 class="text-primary fw-bold text-center mb-3">VISI</h5>
                            <div class="p-4 bg-light rounded-4 text-center" style="font-size: 1.25rem; font-style: italic; font-weight: 500;">
                                "{{ $profil->visi ?? 'Mewujudkan Desa Kalinaun yang Mandiri, Sejahtera, dan Berdaya Saing melalui Tata Kelola yang Transparan.' }}"
                            </div>
                        </div>

                        <div>
                            <h5 class="text-primary fw-bold mb-3">MISI</h5>
                            <div class="list-misi">
                                {!! $profil->misi ?? '<ul><li>Meningkatkan kualitas pelayanan publik.</li><li>Membangun infrastruktur desa yang berkelanjutan.</li><li>Memberdayakan ekonomi kerakyatan melalui potensi lokal.</li></ul>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Geografis -->
                <div class="tab-pane fade" id="v-pills-geografis" role="tabpanel">
                    <div class="card shadow-sm p-4">
                        <h3 class="fw-bold mb-4">Letak Geografis</h3>
                        <div class="row g-3 mb-4">
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
                    <div class="card shadow-sm p-4">
                        <h3 class="fw-bold mb-4 text-center">Struktur Organisasi</h3>
                        <div class="text-center py-5">
                            <i class="fas fa-sitemap fa-5x text-muted opacity-25 mb-4"></i>
                            <p class="text-muted mb-0">Bagan Struktur Organisasi Desa Kalinaun sedang dalam proses pembaruan data.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

