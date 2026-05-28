@extends('layouts.sipakal')

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

    .image-preview {
        margin-top: 1rem;
        max-width: 300px;
    }

    .image-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
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
                <h1><i class="fas fa-edit me-2"></i>Edit Informasi Desa</h1>
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
                    <h5><i class="fas fa-edit"></i> Form Edit Informasi Desa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.informasi-desa.update', $informasi->id) }}" method="POST" enctype="multipart/form-data" id="formInformasi">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Dasar
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('judul') is-invalid @enderror" 
                                       name="judul" 
                                       value="{{ old('judul', $informasi->judul) }}" 
                                       required
                                       placeholder="Masukkan judul informasi">
                                <span class="helper-text">Judul yang menarik dan deskriptif</span>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                                name="kategori" 
                                                required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="berita" {{ old('kategori', $informasi->kategori) == 'berita' ? 'selected' : '' }}>Berita</option>
                                            <option value="pengumuman" {{ old('kategori', $informasi->kategori) == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                            <option value="kegiatan" {{ old('kategori', $informasi->kategori) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                            <option value="lainnya" {{ old('kategori', $informasi->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        <span class="helper-text">Pilih kategori informasi</span>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                name="status" 
                                                required>
                                            <option value="draft" {{ old('status', $informasi->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status', $informasi->status) == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                        <span class="helper-text">Draft: belum dipublikasikan, Published: sudah dipublikasikan</span>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-file-alt"></i>
                                Konten
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('konten') is-invalid @enderror" 
                                          name="konten" 
                                          rows="8" 
                                          required
                                          placeholder="Masukkan konten informasi...">{{ old('konten', $informasi->konten) }}</textarea>
                                <span class="helper-text">Konten utama dari informasi desa</span>
                                @error('konten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-image"></i>
                                Gambar
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" 
                                       class="form-control @error('gambar') is-invalid @enderror" 
                                       name="gambar" 
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                <span class="helper-text">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</span>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($informasi->gambar)
                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="image-preview">
                                    <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="{{ $informasi->judul }}">
                                </div>
                            </div>
                            @endif

                            <div id="imagePreview" class="image-preview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.informasi-desa') }}" class="btn btn-secondary">
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
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

// Validasi form sebelum submit
document.getElementById('formInformasi').addEventListener('submit', function(e) {
    const judul = document.querySelector('input[name="judul"]').value.trim();
    const kategori = document.querySelector('select[name="kategori"]').value;
    const konten = document.querySelector('textarea[name="konten"]').value.trim();
    
    if (!judul) {
        e.preventDefault();
        alert('Judul tidak boleh kosong');
        return false;
    }
    
    if (!kategori) {
        e.preventDefault();
        alert('Kategori harus dipilih');
        return false;
    }
    
    if (!konten) {
        e.preventDefault();
        alert('Konten tidak boleh kosong');
        return false;
    }
});
</script>
@endsection
