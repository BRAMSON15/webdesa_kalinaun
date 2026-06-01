@extends('layouts.masyarakat')

@section('title', 'Informasi Desa - Desa Kalinaun')

@section('content')
<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-bullhorn me-2"></i> Informasi Desa</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('masyarakat.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Informasi Desa</li>
                </ol>
            </nav>
        </div>
        <form method="GET" action="{{ route('masyarakat.informasi-desa') }}" class="input-group" style="max-width: 380px;">
            <input type="text" name="search" class="form-control" placeholder="Cari berita atau pengumuman..." value="{{ request('search') }}">
            <button class="btn btn-success" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="row g-4">
                @if(isset($informasis) && $informasis->count() > 0)
                    @foreach($informasis as $info)
                        <div class="col-12">
                            <article class="card-premium h-100">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="bg-light h-100 d-flex align-items-center justify-content-center border-end" style="min-height: 200px;">
                                            <i class="fas fa-{{ $info->kategori == 'pengumuman' ? 'bullhorn' : 'calendar-alt' }} fa-4x text-primary-light" style="opacity: 0.3;"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="badge {{ $info->kategori == 'pengumuman' ? 'bg-danger' : 'bg-success' }} rounded-pill">
                                                    {{ ucfirst($info->kategori ?? 'Informasi') }}
                                                </span>
                                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $info->created_at->format('d F Y') }}</span>
                                            </div>
                                            <h3 class="fw-bold h4 mb-3">
                                                <a href="{{ route('masyarakat.detail-informasi', $info->id) }}" class="text-dark text-decoration-none hover-primary">
                                                    {{ $info->judul }}
                                                </a>
                                            </h3>
                                            <p class="text-muted mb-4">{{ Str::limit($info->konten, 150) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($info->penulis ?? 'Admin') }}&background=22c55e&color=fff" class="rounded-circle me-2" width="24" height="24">
                                                    <span class="small text-muted">{{ $info->penulis ?? 'Admin Desa' }}</span>
                                                </div>
                                                <a href="{{ route('masyarakat.detail-informasi', $info->id) }}" class="btn btn-sm btn-outline-premium">
                                                    Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="col-12 mt-5">
                        <div class="d-flex justify-content-center">
                            {{ $informasis->links() }}
                        </div>
                    </div>
                @else
                    <!-- Sample Content if Empty -->
                    <div class="col-12 text-center py-5">
                        <div class="card-premium p-5">
                            <i class="fas fa-newspaper fa-4x text-muted mb-3 opacity-25"></i>
                            <h4 class="text-muted">Belum ada informasi publik yang diterbitkan.</h4>
                            <p class="text-muted">Silakan kembali lagi nanti untuk mendapatkan update terbaru.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <!-- Categories -->
            <div class="card-premium p-4 mb-4">
                <h5 class="fw-bold mb-3">Kategori</h5>
                <div class="list-group list-group-flush">
                    <a href="?kategori=" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                        <span>Semua Informasi</span>
                        <span class="badge bg-light text-dark rounded-pill">{{ \App\Models\InformasiDesa::count() }}</span>
                    </a>
                    <a href="?kategori=pengumuman" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                        <span>Pengumuman</span>
                        <span class="badge bg-light text-dark rounded-pill">{{ \App\Models\InformasiDesa::where('kategori', 'pengumuman')->count() }}</span>
                    </a>
                    <a href="?kategori=kegiatan" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                        <span>Kegiatan</span>
                        <span class="badge bg-light text-dark rounded-pill">{{ \App\Models\InformasiDesa::where('kategori', 'kegiatan')->count() }}</span>
                    </a>
                </div>
            </div>

            <!-- Recent Info -->
            <div class="card-premium p-4">
                <h5 class="fw-bold mb-3">Terbaru</h5>
                @php
                    $latestInfo = \App\Models\InformasiDesa::latest()->take(3)->get();
                @endphp
                @foreach($latestInfo as $latest)
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom last-no-border">
                        <div class="flex-shrink-0 bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-{{ $latest->kategori == 'pengumuman' ? 'bullhorn' : 'calendar-alt' }} text-primary"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small">
                                <a href="{{ route('masyarakat.detail-informasi', $latest->id) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($latest->judul, 40) }}
                                </a>
                            </h6>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ $latest->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection