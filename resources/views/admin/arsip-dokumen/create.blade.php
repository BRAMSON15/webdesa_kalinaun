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
                <h1>Tambah Arsip Dokumen</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus"></i> Form Tambah Arsip Dokumen</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.arsip-dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" 
                                       name="nama_dokumen" value="{{ old('nama_dokumen') }}" required
                                       placeholder="Contoh: Peraturan Desa No. 1 Tahun 2024">
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nomor Dokumen</label>
                                <input type="text" class="form-control @error('nomor_dokumen') is-invalid @enderror" 
                                       name="nomor_dokumen" value="{{ old('nomor_dokumen') }}"
                                       placeholder="Contoh: 001/PERDES/2024">
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="surat_masuk" {{ old('kategori') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                    <option value="surat_keluar" {{ old('kategori') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                    <option value="sk" {{ old('kategori') == 'sk' ? 'selected' : '' }}>Surat Keputusan</option>
                                    <option value="perdes" {{ old('kategori') == 'perdes' ? 'selected' : '' }}>Peraturan Desa</option>
                                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror" 
                                       name="tanggal_dokumen" value="{{ old('tanggal_dokumen') }}" required>
                                @error('tanggal_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="4" 
                                      placeholder="Deskripsi singkat tentang dokumen ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">File Dokumen <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   name="file" accept=".pdf,.doc,.docx" required>
                            <small class="text-muted">Format: PDF, DOC, DOCX. Maksimal 10MB.</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Arsip
                            </button>
                            <a href="{{ route('admin.arsip-dokumen') }}" class="btn btn-secondary">
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