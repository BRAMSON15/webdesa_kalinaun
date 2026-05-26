@extends('layouts.sipakal')

@section('title', 'Detail Program Bansos')

@section('body')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <small>Detail Program</small>
            </h1>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary">
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

                <div class="row">
                    <!-- Detail Program -->
                    <div class="col-lg-8 col-md-7 mb-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 fs-6">Informasi Program</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <strong>Nama Program:</strong><br>
                                        {{ $bansos->nama_bansos }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Jenis Bansos:</strong><br>
                                        {{ $bansos->jenis_bansos }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <strong>Tanggal Mulai:</strong><br>
                                        {{ $bansos->tanggal_mulai->format('d/m/Y') }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Tanggal Selesai:</strong><br>
                                        {{ $bansos->tanggal_selesai->format('d/m/Y') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <strong>Status:</strong><br>
                                        @switch($bansos->status)
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
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Nominal per Penerima:</strong><br>
                                        Rp {{ number_format($bansos->nominal, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <strong>Deskripsi:</strong><br>
                                    <p class="text-justify mb-0">{{ $bansos->deskripsi }}</p>
                                </div>

                                @if ($bansos->syarat_ketentuan)
                                    <div class="mb-0">
                                        <strong>Syarat & Ketentuan:</strong><br>
                                        <p class="text-justify mb-0">{{ $bansos->syarat_ketentuan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Statistik Penerima -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0 fs-6">Statistik Penerima</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-3">
                                        <h3 class="text-primary fw-bold">{{ $statistik['total_penerima'] }}</h3>
                                        <p class="text-muted small mb-0">Total Pendaftar</p>
                                    </div>
                                    <div class="col-3">
                                        <h3 class="text-success fw-bold">{{ $statistik['disetujui'] }}</h3>
                                        <p class="text-muted small mb-0">Disetujui</p>
                                    </div>
                                    <div class="col-3">
                                        <h3 class="text-warning fw-bold">{{ $statistik['menunggu'] }}</h3>
                                        <p class="text-muted small mb-0">Menunggu</p>
                                    </div>
                                    <div class="col-3">
                                        <h3 class="text-danger fw-bold">{{ $statistik['ditolak'] }}</h3>
                                        <p class="text-muted small mb-0">Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Actions -->
                    <div class="col-lg-4 col-md-5">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0 fs-6">Kuota Program</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Kuota Tersedia:</strong><br>
                                    <h4 class="text-primary fw-bold mt-1">{{ $bansos->kuota - $bansos->kuota_terpakai }} / {{ $bansos->kuota }}</h4>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ ($bansos->kuota_terpakai / $bansos->kuota) * 100 }}%;" 
                                         aria-valuenow="{{ $bansos->kuota_terpakai }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $bansos->kuota }}">
                                        {{ round(($bansos->kuota_terpakai / $bansos->kuota) * 100) }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0 fs-6">Aksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.bansos.edit', $bansos) }}" class="btn btn-warning text-dark">
                                        <i class="fas fa-edit"></i> Edit Program
                                    </a>
                                    <a href="{{ route('admin.bansos.manage-penerima', $bansos) }}" class="btn btn-primary">
                                        <i class="fas fa-users"></i> Kelola Penerima
                                    </a>
                                    <form action="{{ route('admin.bansos.destroy', $bansos) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus program ini?')">
                                            <i class="fas fa-trash"></i> Hapus Program
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

