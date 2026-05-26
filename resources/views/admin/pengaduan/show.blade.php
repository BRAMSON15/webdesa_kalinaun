@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-comments"></i> Detail Pengaduan</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Detail Pengaduan -->
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
                            <strong>Status:</strong><br>
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

                    @if ($pengaduan->tanggal_selesai)
                        <div class="mb-3">
                            <strong>Tanggal Selesai:</strong><br>
                            {{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Data Pelapor -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Data Pelapor</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama:</strong><br>
                            {{ $pengaduan->user->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            {{ $pengaduan->user->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>NIK:</strong><br>
                            {{ $pengaduan->user->nik ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>No. HP:</strong><br>
                            {{ $pengaduan->user->no_hp ?? '-' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Alamat:</strong><br>
                        {{ $pengaduan->user->alamat ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Update Status -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status">Status Pengaduan:</label>
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
                            <label for="catatan_admin">Catatan Admin:</label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror" rows="5" placeholder="Masukkan catatan atau tindakan yang telah dilakukan...">{{ $pengaduan->catatan_admin }}</textarea>
                            @error('catatan_admin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            @if ($pengaduan->admin)
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
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
