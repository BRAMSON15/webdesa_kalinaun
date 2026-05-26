@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Edit Pengaduan</h2>
        </div>
        <div class="col-md-4 text-right">
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Edit Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="judul">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul pengaduan" value="{{ old('judul', $pengaduan->judul) }}" required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori Pengaduan <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
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

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            <small class="form-text text-muted">Minimal 10 karakter</small>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Anda hanya dapat mengedit pengaduan dengan status "Baru"</li>
                                <li>Setelah status berubah, pengaduan tidak dapat diubah lagi</li>
                                <li>Perubahan akan dicatat dalam sistem</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
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
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Status:</strong><br>
                        @switch($pengaduan->status)
                            @case('baru')
                                <span class="badge badge-warning">Baru</span>
                                @break
                            @case('diproses')
                                <span class="badge badge-info">Diproses</span>
                                @break
                            @case('selesai')
                                <span class="badge badge-success">Selesai</span>
                                @break
                            @case('ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                                @break
                        @endswitch
                    </p>
                    <p><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Aksi Lainnya</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.pengaduan.destroy', $pengaduan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.')">
                            <i class="fas fa-trash"></i> Hapus Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
