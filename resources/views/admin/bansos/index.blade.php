@extends('layouts.sipakal')
@section('title', 'Kelola Program Bansos')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('admin.partials.header')
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>
    <div class="dashboard-main">
        <section class="dashboard-header d-flex justify-content-between align-items-center flex-wrap">
            <h1>
                Kelola Program Bansos
                <small>Daftar Program</small>
            </h1>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('admin.bansos.create') }}" class="btn btn-success me-2">
                    <i class="fas fa-plus"></i> Tambah Program
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </section>
        <section class="dashboard-content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Filter Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fs-6"><i class="fas fa-filter"></i> Filter Program</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.bansos.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="search" class="form-label">Pencarian:</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari nama program..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fs-6"><i class="fas fa-list"></i> Daftar Program Bansos</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Program</th>
                                        <th>Jenis</th>
                                        <th>Periode</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bansos as $index => $program)
                                        <tr>
                                            <td>{{ $bansos->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $program->nama_bansos }}</strong>
                                            </td>
                                            <td>{{ $program->jenis_bansos }}</td>
                                            <td>
                                                {{ $program->tanggal_mulai->format('d/m/Y') }} - {{ $program->tanggal_selesai->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $program->kuota_terpakai }}/{{ $program->kuota }}</span>
                                            </td>
                                            <td>
                                                @switch($program->status)
                                                    @case('aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                        @break
                                                    @case('nonaktif')
                                                        <span class="badge bg-warning text-dark">Nonaktif</span>
                                                        @break
                                                    @case('selesai')
                                                        <span class="badge bg-secondary">Selesai</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.bansos.show', $program) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.bansos.edit', $program) }}" class="btn btn-sm btn-warning text-dark" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.bansos.manage-penerima', $program) }}" class="btn btn-sm btn-primary" title="Kelola Penerima">
                                                    <i class="fas fa-users"></i>
                                                </a>
                                                <form action="{{ route('admin.bansos.destroy', $program) }}" method="POST" style="display:inline;">
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
                                                Tidak ada program bansos
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $bansos->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
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
