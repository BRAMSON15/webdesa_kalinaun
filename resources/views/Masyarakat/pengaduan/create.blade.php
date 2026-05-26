@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-plus"></i> Buat Pengaduan</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="judul">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul pengaduan" value="{{ old('judul') }}" required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori Pengaduan <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="layanan" {{ old('kategori') == 'layanan' ? 'selected' : '' }}>Layanan Publik</option>
                                <option value="infrastruktur" {{ old('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="kesehatan" {{ old('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi') }}</textarea>
                            <small class="form-text text-muted">Minimal 10 karakter</small>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Informasi Penting:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pengaduan Anda akan ditinjau oleh admin desa</li>
                                <li>Anda dapat mengedit pengaduan selama status masih "Baru"</li>
                                <li>Kami akan memberikan update melalui email Anda</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                            </button>
                            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Panduan Pengaduan</h5>
                </div>
                <div class="card-body">
                    <h6>Tips Membuat Pengaduan yang Baik:</h6>
                    <ul class="small">
                        <li>Jelaskan masalah dengan jelas dan detail</li>
                        <li>Sertakan lokasi atau tempat kejadian</li>
                        <li>Cantumkan waktu kejadian jika relevan</li>
                        <li>Hindari bahasa yang kasar atau menyerang</li>
                        <li>Berikan solusi atau saran jika memungkinkan</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Status Pengaduan</h5>
                </div>
                <div class="card-body small">
                    <p><strong>Baru:</strong> Pengaduan baru diterima</p>
                    <p><strong>Diproses:</strong> Admin sedang menangani</p>
                    <p><strong>Selesai:</strong> Pengaduan telah ditindaklanjuti</p>
                    <p class="mb-0"><strong>Ditolak:</strong> Pengaduan tidak dapat ditindaklanjuti</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
