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
                <h1>Tambah Informasi Desa</h1>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus"></i> Form Tambah Informasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.informasi-desa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                    <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" 
                                      name="konten" rows="8" required>{{ old('konten') }}</textarea>
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   name="gambar" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="published" id="published">
                                <label class="form-check-label" for="published">
                                    Publikasikan langsung
                                </label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Informasi
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
@endsection