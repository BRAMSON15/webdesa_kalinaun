@extends('layouts.masyarakat')

@section('title', $informasi->judul . ' - Desa Kalinaun')

@section('content')
<div>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-bullhorn me-2"></i> Detail Informasi</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('masyarakat.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('masyarakat.informasi-desa') }}" class="text-decoration-none">Informasi Desa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('masyarakat.informasi-desa') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge {{ $informasi->kategori == 'pengumuman' ? 'bg-danger' : 'bg-success' }} rounded-pill px-3 py-2 fs-7">
                            {{ ucfirst($informasi->kategori ?? 'Informasi') }}
                        </span>
                        <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $informasi->created_at->format('d F Y') }}</span>
                    </div>

                    <h1 class="fw-bold h2 mb-4 text-dark lh-base">{{ $informasi->judul }}</h1>

                    <div class="d-flex align-items-center border-top border-bottom py-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($informasi->penulis ?? 'Admin') }}&background=22c55e&color=fff" class="rounded-circle me-3" width="40" height="40">
                        <div>
                            <div class="fw-bold text-dark">{{ $informasi->penulis ?? 'Admin Desa' }}</div>
                            <small class="text-muted">Kontributor Desa Kalinaun</small>
                        </div>
                    </div>

                    @if($informasi->gambar)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $informasi->gambar) }}" class="img-fluid rounded" alt="{{ $informasi->judul }}" style="max-height: 450px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="lh-lg text-secondary fs-6" style="text-align: justify; white-space: pre-line;">
                        {{ $informasi->konten }}
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-lg-4">
            <!-- Related news -->
            <div class="card shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Terbaru</h5>
                @php
                    $latestInfo = \App\Models\InformasiDesa::published()
                        ->where('id', '!=', $informasi->id)
                        ->latest()
                        ->take(4)
                        ->get();
                @endphp
                @if($latestInfo->count() > 0)
                    @foreach($latestInfo as $latest)
                        <div class="d-flex gap-3 mb-3 pb-3 border-bottom last-no-border">
                            <div class="flex-shrink-0 bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-{{ $latest->kategori == 'pengumuman' ? 'bullhorn' : 'calendar-alt' }} text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 small" style="line-height: 1.4;">
                                    <a href="{{ route('masyarakat.detail-informasi', $latest->id) }}" class="text-dark text-decoration-none hover-primary">
                                        {{ Str::limit($latest->judul, 45) }}
                                    </a>
                                </h6>
                                <span class="text-muted" style="font-size: 0.75rem;">{{ $latest->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small mb-0">Tidak ada informasi terbaru lainnya.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
