@extends('layouts.sipakal')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
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
