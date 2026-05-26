@extends('layouts.sipakal')

@section('title', 'Edit Pengaduan')

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
                Edit Status Pengaduan
                <small class="text-muted fs-6">Update Pengaduan</small>
            </h1>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Form Update -->
                    <div class="col-lg-8 col-md-7 mb-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 fs-6">Informasi Pengaduan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <strong>Judul:</strong><br>
                                        {{ $pengaduan->judul }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Kategori:</strong><br>
                                        <span class="badge bg-info">{{ ucfirst($pengaduan->kategori) }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <strong>Tanggal Pengaduan:</strong><br>
                                        {{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Status Saat Ini:</strong><br>
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
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <strong>Deskripsi:</strong><br>
                                    <p class="text-justify mb-0">{{ $pengaduan->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0 fs-6">Update Status Pengaduan</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status Pengaduan <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="baru" {{ $pengaduan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan_admin" class="form-label">Catatan Admin <span class="text-danger">*</span></label>
                                        <textarea name="catatan_admin" id="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror" rows="6" placeholder="Masukkan catatan atau tindakan yang telah dilakukan..." required>{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                                        <div class="form-text text-muted">Catatan ini akan ditampilkan kepada pelapor</div>
                                        @error('catatan_admin')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="alert alert-info py-2 px-3 mb-3">
                                        <i class="fas fa-info-circle"></i> <strong>Informasi:</strong>
                                        <ul class="mb-0 mt-1 ps-3 small">
                                            <li>Perubahan status akan dikirimkan ke pelapor melalui email</li>
                                            <li>Catatan admin akan terlihat oleh pelapor</li>
                                            <li>Jika status "Selesai" atau "Ditolak", tanggal selesai akan dicatat otomatis</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Details -->
                    <div class="col-lg-4 col-md-5">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0 fs-6">Data Pelapor</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Nama:</strong><br>{{ $pengaduan->user->name }}</p>
                                <p><strong>Email:</strong><br>{{ $pengaduan->user->email }}</p>
                                <p><strong>NIK:</strong><br>{{ $pengaduan->user->nik ?? '-' }}</p>
                                <p class="mb-0"><strong>No. HP:</strong><br>{{ $pengaduan->user->no_hp ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0 fs-6">Informasi Pengaduan</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                                @if ($pengaduan->tanggal_selesai)
                                    <p class="mb-0"><strong>Tanggal Selesai:</strong><br>{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        @if ($pengaduan->admin)
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0 fs-6">Admin Penangani</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $pengaduan->admin->username ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endif
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

