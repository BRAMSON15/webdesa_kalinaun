@extends('layouts.masyarakat')

@section('title', 'Edit Pengaduan')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Pengaduan</h2>
        <div>
            <a href="{{ route('masyarakat.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
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
                    <h5 class="mb-0 fs-6">Form Edit Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul pengaduan" value="{{ old('judul', $pengaduan->judul) }}" required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="layanan" {{ old('kategori', $pengaduan->kategori) == 'layanan' ? 'selected' : '' }}>Layanan Publik</option>
                                <option value="infrastruktur" {{ old('kategori', $pengaduan->kategori) == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="kesehatan" {{ old('kategori', $pengaduan->kategori) == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="pendidikan" {{ old('kategori', $pengaduan->kategori) == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="lainnya" {{ old('kategori', $pengaduan->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            <div class="form-text text-muted">Minimal 10 karakter</div>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-warning py-2 px-3 mb-3">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian:</strong>
                            <ul class="mb-0 mt-1 ps-3 small">
                                <li>Anda hanya dapat mengedit pengaduan dengan status "Baru"</li>
                                <li>Setelah status berubah, pengaduan tidak dapat diubah lagi</li>
                                <li>Perubahan akan dicatat dalam sistem</li>
                            </ul>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('masyarakat.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
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
                    <h5 class="mb-0 fs-6">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-2"><strong>Status:</strong><br>
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
                    </p>
                    <p class="mb-2"><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fs-6">Aksi Lainnya</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.destroy', $pengaduan) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.')">
                            <i class="fas fa-trash"></i> Hapus Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
