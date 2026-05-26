@extends('layouts.masyarakat')

@section('title', 'Buat Pengaduan')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-plus me-2"></i> Buat Pengaduan</h2>
        <div>
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fs-6">Form Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul pengaduan" value="{{ old('judul') }}" required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
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

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi') }}</textarea>
                            <div class="form-text text-muted">Minimal 10 karakter</div>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info py-2 px-3 mb-3">
                            <i class="fas fa-info-circle"></i> <strong>Informasi Penting:</strong>
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li>Pengaduan Anda akan ditinjau oleh admin desa</li>
                                <li>Anda dapat mengedit pengaduan selama status masih "Baru"</li>
                                <li>Kami akan memberikan update melalui email Anda</li>
                            </ul>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary me-2">
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
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fs-6">Panduan Pengaduan</h5>
                </div>
                <div class="card-body">
                    <h6 class="fs-6">Tips Membuat Pengaduan yang Baik:</h6>
                    <ul class="small ps-3 mb-0">
                        <li>Jelaskan masalah dengan jelas dan detail</li>
                        <li>Sertakan lokasi atau tempat kejadian</li>
                        <li>Cantumkan waktu kejadian jika relevan</li>
                        <li>Hindari bahasa yang kasar atau menyerang</li>
                        <li>Berikan solusi atau saran jika memungkinkan</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0 fs-6">Status Pengaduan</h5>
                </div>
                <div class="card-body small">
                    <p class="mb-2"><strong>Baru:</strong> Pengaduan baru diterima</p>
                    <p class="mb-2"><strong>Diproses:</strong> Admin sedang menangani</p>
                    <p class="mb-2"><strong>Selesai:</strong> Pengaduan telah ditindaklanjuti</p>
                    <p class="mb-0"><strong>Ditolak:</strong> Pengaduan tidak dapat ditindaklanjuti</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
