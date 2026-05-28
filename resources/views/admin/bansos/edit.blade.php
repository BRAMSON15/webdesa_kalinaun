@extends('layouts.sipakal')

@section('title', 'Edit Program Bansos')

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

    .text-danger {
        color: #dc3545;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section-title i {
        color: #667eea;
        font-size: 1.2rem;
    }

    .helper-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
        display: block;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #dee2e6;
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

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    .info-box {
        background-color: #e7f3ff;
        border-left: 4px solid #667eea;
        padding: 0.75rem;
        border-radius: 0.25rem;
        margin-top: 0.5rem;
    }

    .info-box .form-text {
        color: #0c5460;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
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
                <h1><i class="fas fa-edit me-2"></i>Edit Program Bansos</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-edit"></i> Form Edit Program Bansos</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bansos.update', $bansos->id) }}" method="POST" id="formBansos">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Dasar Program
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Program <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_bansos') is-invalid @enderror" 
                                       name="nama_bansos" 
                                       value="{{ $bansos->nama_bansos }}" 
                                       required
                                       placeholder="Masukkan nama program bansos">
                                <span class="helper-text">Nama program yang jelas dan deskriptif</span>
                                @error('nama_bansos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Bansos <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('jenis_bansos') is-invalid @enderror" 
                                       name="jenis_bansos" 
                                       value="{{ $bansos->jenis_bansos }}" 
                                       required
                                       placeholder="Contoh: Uang Tunai, Sembako, Beasiswa">
                                <span class="helper-text">Jenis bantuan sosial yang diberikan</span>
                                @error('jenis_bansos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                name="status" 
                                                required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="aktif" {{ $bansos->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ $bansos->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            <option value="selesai" {{ $bansos->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                        <span class="helper-text">Status program bansos</span>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-file-alt"></i>
                                Deskripsi & Ketentuan
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" 
                                          rows="4" 
                                          required
                                          placeholder="Masukkan deskripsi program bansos...">{{ $bansos->deskripsi }}</textarea>
                                <span class="helper-text">Penjelasan detail tentang program bansos</span>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Syarat & Ketentuan</label>
                                <textarea class="form-control @error('syarat_ketentuan') is-invalid @enderror" 
                                          name="syarat_ketentuan" 
                                          rows="4"
                                          placeholder="Masukkan syarat dan ketentuan program...">{{ $bansos->syarat_ketentuan }}</textarea>
                                <span class="helper-text">Syarat dan ketentuan yang harus dipenuhi penerima</span>
                                @error('syarat_ketentuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kuota & Nominal -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-chart-bar"></i>
                                Kuota & Nominal
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kuota <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               class="form-control @error('kuota') is-invalid @enderror" 
                                               name="kuota" 
                                               value="{{ $bansos->kuota }}" 
                                               min="1" 
                                               required
                                               placeholder="Jumlah penerima">
                                        <div class="info-box">
                                            <span class="form-text"><strong>Kuota terpakai:</strong> {{ $bansos->kuota_terpakai }} / {{ $bansos->kuota }}</span>
                                        </div>
                                        <span class="helper-text">Jumlah maksimal penerima bansos</span>
                                        @error('kuota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nominal (Rp)</label>
                                        <input type="number" 
                                               class="form-control @error('nominal') is-invalid @enderror" 
                                               name="nominal" 
                                               value="{{ $bansos->nominal }}" 
                                               min="0" 
                                               step="0.01"
                                               placeholder="Nominal per penerima">
                                        <span class="helper-text">Nominal bantuan per penerima (opsional)</span>
                                        @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Periode -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-calendar-alt"></i>
                                Periode Program
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                               name="tanggal_mulai" 
                                               value="{{ $bansos->tanggal_mulai->format('Y-m-d') }}" 
                                               required>
                                        <span class="helper-text">Tanggal program dimulai</span>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                               name="tanggal_selesai" 
                                               value="{{ $bansos->tanggal_selesai->format('Y-m-d') }}" 
                                               required>
                                        <span class="helper-text">Tanggal program berakhir</span>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-sticky-note"></i>
                                Catatan Tambahan
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                          name="catatan" 
                                          rows="3"
                                          placeholder="Catatan atau informasi tambahan...">{{ $bansos->catatan }}</textarea>
                                <span class="helper-text">Informasi tambahan tentang program (opsional)</span>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Validasi form sebelum submit
document.getElementById('formBansos').addEventListener('submit', function(e) {
    const nama = document.querySelector('input[name="nama_bansos"]').value.trim();
    const jenis = document.querySelector('input[name="jenis_bansos"]').value.trim();
    const deskripsi = document.querySelector('textarea[name="deskripsi"]').value.trim();
    const kuota = document.querySelector('input[name="kuota"]').value;
    const tglMulai = document.querySelector('input[name="tanggal_mulai"]').value;
    const tglSelesai = document.querySelector('input[name="tanggal_selesai"]').value;
    
    if (!nama) {
        e.preventDefault();
        alert('Nama program tidak boleh kosong');
        return false;
    }
    
    if (!jenis) {
        e.preventDefault();
        alert('Jenis bansos tidak boleh kosong');
        return false;
    }
    
    if (!deskripsi) {
        e.preventDefault();
        alert('Deskripsi tidak boleh kosong');
        return false;
    }
    
    if (!kuota || kuota < 1) {
        e.preventDefault();
        alert('Kuota harus lebih dari 0');
        return false;
    }
    
    if (!tglMulai || !tglSelesai) {
        e.preventDefault();
        alert('Tanggal mulai dan selesai harus diisi');
        return false;
    }
    
    if (new Date(tglMulai) > new Date(tglSelesai)) {
        e.preventDefault();
        alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
        return false;
    }
});
</script>
@endsection

