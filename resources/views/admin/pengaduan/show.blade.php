@extends('layouts.sipakal')

@section('title', 'Detail Pengaduan')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<style>
    .dashboard-content {
        padding: 2rem;
        background-color: #f8f9fa;
    }

    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0;
        padding: 1.5rem;
        border: none;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .card-header i {
        margin-right: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 150px;
    }

    .info-value {
        color: #2c3e50;
        flex: 1;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(108, 117, 125, 0.3);
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #667eea;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .info-row {
            flex-direction: column;
        }

        .info-label {
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        @include('admin.partials.header')

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1><i class="fas fa-info-circle me-2"></i>Detail Pengaduan</h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Detail Pengaduan -->
                <div class="col-lg-8 col-md-7 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-file-alt"></i> Informasi Pengaduan</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Judul:</span>
                                <span class="info-value"><strong>{{ $pengaduan->judul }}</strong></span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Kategori:</span>
                                <span class="info-value">
                                    <span class="badge bg-info">{{ ucfirst($pengaduan->kategori) }}</span>
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Tanggal Pengaduan:</span>
                                <span class="info-value">{{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="info-value">
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
                                </span>
                            </div>

                            @if ($pengaduan->tanggal_selesai)
                                <div class="info-row">
                                    <span class="info-label">Tanggal Selesai:</span>
                                    <span class="info-value">{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif

                            <div style="padding: 1rem 0; border-top: 1px solid #dee2e6;">
                                <strong class="d-block mb-2">Deskripsi:</strong>
                                <p class="text-justify mb-0">{{ $pengaduan->deskripsi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pelapor -->
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <h5><i class="fas fa-user"></i> Data Pelapor</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Nama:</span>
                                <span class="info-value"><strong>{{ $pengaduan->user->name }}</strong></span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $pengaduan->user->email }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">NIK:</span>
                                <span class="info-value">{{ $pengaduan->user->nik ?? '-' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">No. HP:</span>
                                <span class="info-value">{{ $pengaduan->user->no_hp ?? '-' }}</span>
                            </div>

                            <div style="padding: 1rem 0; border-top: 1px solid #dee2e6;">
                                <span class="info-label d-block mb-2">Alamat:</span>
                                <span class="info-value">{{ $pengaduan->user->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Update Status & Info Admin -->
                <div class="col-lg-4 col-md-5">
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <h5><i class="fas fa-edit"></i> Update Status</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST" id="formUpdate">
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="catatan_admin" class="form-label">Catatan Admin</label>
                                    <textarea name="catatan_admin" id="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror" rows="5" placeholder="Masukkan catatan atau tindakan yang telah dilakukan...">{{ $pengaduan->catatan_admin }}</textarea>
                                    @error('catatan_admin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($pengaduan->admin)
                        <div class="card">
                            <div class="card-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                                <h5><i class="fas fa-user-tie"></i> Admin Penangani</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">Username:</span>
                                    <span class="info-value"><strong>{{ $pengaduan->admin->username ?? 'N/A' }}</strong></span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div style="margin-top: 1rem;">
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Validasi form sebelum submit
document.getElementById('formUpdate').addEventListener('submit', function(e) {
    const status = document.querySelector('select[name="status"]').value;
    
    if (!status) {
        e.preventDefault();
        alert('Status harus dipilih');
        return false;
    }
});
</script>
@endsection
