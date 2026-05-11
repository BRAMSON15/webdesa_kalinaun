<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Desa - SIPAKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardmasyarakat.css') }}">
</head>
<body>
    <div class="dashboard-container">
        @include('Masyarakat.partials.header')
        @include('Masyarakat.partials.sidebar')
        
        <div class="dashboard-main">
            <div class="dashboard-content">
                <div class="container-fluid mt-4">
                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-primary">
                                        <i class="fas fa-info-circle"></i> Informasi Desa
                                    </h4>
                                    <p class="card-text">Dapatkan informasi terbaru tentang kegiatan dan pengumuman desa.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('masyarakat.informasi-desa') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="Cari informasi..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="kategori" id="semua" value="" 
                                       {{ request('kategori') == '' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="semua">Semua</label>

                                <input type="radio" class="btn-check" name="kategori" id="pengumuman" value="pengumuman"
                                       {{ request('kategori') == 'pengumuman' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="pengumuman">Pengumuman</label>

                                <input type="radio" class="btn-check" name="kategori" id="kegiatan" value="kegiatan"
                                       {{ request('kategori') == 'kegiatan' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="kegiatan">Kegiatan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Information Cards -->
                    <div class="row">
                        @if(isset($informasiDesa) && $informasiDesa->count() > 0)
                            @foreach($informasiDesa as $info)
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-{{ $info->kategori == 'pengumuman' ? 'bullhorn' : 'calendar-alt' }}"></i>
                                                    {{ ucfirst($info->kategori ?? 'Informasi') }}
                                                </h6>
                                                <small>{{ $info->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $info->judul }}</h5>
                                            <p class="card-text">{{ Str::limit($info->konten, 150) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $info->penulis ?? 'Admin Desa' }}
                                                </small>
                                                <a href="{{ route('masyarakat.detail-informasi', $info->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="col-12">
                                <div class="d-flex justify-content-center">
                                    {{ $informasiDesa->links() }}
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <i class="fas fa-info-circle fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum Ada Informasi</h5>
                                        <p class="text-muted">Informasi desa akan ditampilkan di sini ketika tersedia.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sample Information (if no data) -->
                    @if(!isset($informasiDesa) || $informasiDesa->count() == 0)
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-bullhorn"></i> Pengumuman
                                            </h6>
                                            <small>{{ date('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Jadwal Pelayanan Surat</h5>
                                        <p class="card-text">Pelayanan surat menyurat di kantor desa tersedia setiap hari Senin-Jumat pukul 08.00-15.00 WIB.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i> Admin Desa
                                            </small>
                                            <button class="btn btn-sm btn-outline-primary" disabled>
                                                <i class="fas fa-eye"></i> Baca Selengkapnya
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-success text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-calendar-alt"></i> Kegiatan
                                            </h6>
                                            <small>{{ date('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Gotong Royong Mingguan</h5>
                                        <p class="card-text">Kegiatan gotong royong rutin setiap hari Minggu pagi untuk menjaga kebersihan lingkungan desa.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i> Kepala Desa
                                            </small>
                                            <button class="btn btn-sm btn-outline-primary" disabled>
                                                <i class="fas fa-eye"></i> Baca Selengkapnya
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('Masyarakat.partials.scripts')
</body>
</html>