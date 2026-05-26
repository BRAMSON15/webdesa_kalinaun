@extends('layouts.sipakal')

@section('title', 'Kelola Pengaduan Masyarakat')

@section('body')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">

<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('admin.partials.header')

    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Kelola Pengaduan Masyarakat
                <small>Daftar Pengaduan</small>
            </h1>
        </section>

        <section class="dashboard-content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fs-6"><i class="fas fa-filter"></i> Filter Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="kategori" class="form-label">Kategori:</label>
                                <select name="kategori" id="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <option value="layanan" {{ request('kategori') == 'layanan' ? 'selected' : '' }}>Layanan</option>
                                    <option value="infrastruktur" {{ request('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                    <option value="kesehatan" {{ request('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="pendidikan" {{ request('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="search" class="form-label">Pencarian:</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fs-6">Total Pengaduan</h5>
                                <h2 class="text-primary fw-bold">{{ $pengaduans->total() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fs-6">Baru</h5>
                                <h2 class="text-warning fw-bold">{{ \App\Models\Pengaduan::where('status', 'baru')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fs-6">Diproses</h5>
                                <h2 class="text-info fw-bold">{{ \App\Models\Pengaduan::where('status', 'diproses')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fs-6">Selesai</h5>
                                <h2 class="text-success fw-bold">{{ \App\Models\Pengaduan::where('status', 'selesai')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fs-6"><i class="fas fa-list"></i> Daftar Pengaduan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Pelapor</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengaduans as $index => $pengaduan)
                                        <tr>
                                            <td>{{ $pengaduans->firstItem() + $index }}</td>
                                            <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <strong>{{ Str::limit($pengaduan->judul, 30) }}</strong>
                                            </td>
                                            <td>{{ $pengaduan->user->name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($pengaduan->kategori) }}</span>
                                            </td>
                                            <td>
                                                @switch($pengaduan->status)
                                                    @case('baru')
                                                        <span class="badge bg-warning text-dark">Baru</span>
                                                        @break
                                                    @case('diproses')
                                                        <span class="badge bg-info">Diproses</span>
                                                        @break
                                                    @case('selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                        @break
                                                    @case('ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Tidak ada pengaduan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $pengaduans->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const mainContent = document.querySelector('.dashboard-main');
        
        if (sidebarToggle && sidebar && mainContent) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        }
    });
</script>
@endsection
