@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Edit Status Pengaduan</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
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
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Judul:</strong><br>
                            {{ $pengaduan->judul }}
                        </div>
                        <div class="col-md-6">
                            <strong>Kategori:</strong><br>
                            <span class="badge badge-info">{{ ucfirst($pengaduan->kategori) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Pengaduan:</strong><br>
                            {{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status Saat Ini:</strong><br>
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
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Deskripsi:</strong><br>
                        <p class="text-justify">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Update Status Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status">Status Pengaduan <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="baru" {{ $pengaduan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan_admin">Catatan Admin <span class="text-danger">*</span></label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror" rows="6" placeholder="Masukkan catatan atau tindakan yang telah dilakukan..." required>{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                            <small class="form-text text-muted">Catatan ini akan ditampilkan kepada pelapor</small>
                            @error('catatan_admin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Perubahan status akan dikirimkan ke pelapor melalui email</li>
                                <li>Catatan admin akan terlihat oleh pelapor</li>
                                <li>Jika status "Selesai" atau "Ditolak", tanggal selesai akan dicatat otomatis</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Data Pelapor</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong><br>{{ $pengaduan->user->name }}</p>
                    <p><strong>Email:</strong><br>{{ $pengaduan->user->email }}</p>
                    <p><strong>NIK:</strong><br>{{ $pengaduan->user->nik ?? '-' }}</p>
                    <p class="mb-0"><strong>No. HP:</strong><br>{{ $pengaduan->user->no_hp ?? '-' }}</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                    @if ($pengaduan->tanggal_selesai)
                        <p class="mb-0"><strong>Tanggal Selesai:</strong><br>{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            @if ($pengaduan->admin)
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Admin Penangani</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $pengaduan->admin->username ?? 'N/A' }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
