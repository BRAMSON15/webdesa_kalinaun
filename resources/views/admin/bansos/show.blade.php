@extends('layouts.sipakal')
@section('title', 'Detail Program Bansos')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<link rel="stylesheet" href="{{ asset('css/bansos2.css') }}">
<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>
    <div class="dashboard-main">
        @include('admin.partials.header')
        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1><i class="fas fa-info-circle me-2"></i>Detail Program Bansos</h1>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <!-- Detail Program -->
                <div class="col-lg-8 col-md-7 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-file-alt"></i> Informasi Program</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Nama Program:</span>
                                <span class="info-value"><strong>{{ $bansos->nama_bansos }}</strong></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jenis Bansos:</span>
                                <span class="info-value">{{ $bansos->jenis_bansos }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Mulai:</span>
                                <span class="info-value">{{ $bansos->tanggal_mulai ? $bansos->tanggal_mulai->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Selesai:</span>
                                <span class="info-value">{{ $bansos->tanggal_selesai ? $bansos->tanggal_selesai->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="info-value">
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
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Nominal per Penerima:</span>
                                <span class="info-value"><strong>Rp {{ number_format($bansos->nominal, 0, ',', '.') }}</strong></span>
                            </div>
                            <div style="padding: 1rem 0; border-top: 1px solid #dee2e6;">
                                <strong class="d-block mb-2">Deskripsi:</strong>
                                <p class="text-justify mb-0">{{ $bansos->deskripsi }}</p>
                            </div>
                            @if ($bansos->syarat_ketentuan)
                                <div style="padding: 1rem 0; border-top: 1px solid #dee2e6;">
                                    <strong class="d-block mb-2">Syarat & Ketentuan:</strong>
                                    <p class="text-justify mb-0">{{ $bansos->syarat_ketentuan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Statistik Penerima -->
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <h5><i class="fas fa-chart-pie"></i> Statistik Penerima</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="stat-card">
                                        <h3 class="text-primary">{{ $statistik['total_penerima'] }}</h3>
                                        <p>Total Pendaftar</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="stat-card">
                                        <h3 class="text-success">{{ $statistik['disetujui'] }}</h3>
                                        <p>Disetujui</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="stat-card">
                                        <h3 class="text-warning">{{ $statistik['menunggu'] }}</h3>
                                        <p>Menunggu</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="stat-card">
                                        <h3 class="text-danger">{{ $statistik['ditolak'] }}</h3>
                                        <p>Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Actions -->
                <div class="col-lg-4 col-md-5">
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <h5><i class="fas fa-chart-bar"></i> Kuota Program</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Kuota Tersedia:</strong>
                                <h4 class="text-primary fw-bold mt-2">{{ $bansos->kuota - $bansos->kuota_terpakai }} / {{ $bansos->kuota }}</h4>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $bansos->kuota > 0 ? ($bansos->kuota_terpakai / $bansos->kuota) * 100 : 0 }}%;" 
                                     aria-valuenow="{{ $bansos->kuota_terpakai }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $bansos->kuota }}">
                                    {{ $bansos->kuota > 0 ? round(($bansos->kuota_terpakai / $bansos->kuota) * 100) : 0 }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                            <h5><i class="fas fa-cog"></i> Aksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.bansos.edit', $bansos) }}" class="btn btn-warning">
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
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
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

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
