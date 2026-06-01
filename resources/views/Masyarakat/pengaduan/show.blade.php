@extends('layouts.masyarakat')

@section('title', 'Detail Pengaduan')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-comments me-2"></i> Detail Pengaduan</h2>
        <div>
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fs-6">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Judul:</strong><br>
                            {{ $pengaduan->judul }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Kategori:</strong><br>
                            <span class="badge bg-info">{{ ucfirst($pengaduan->kategori) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Tanggal Pengaduan:</strong><br>
                            {{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong><br>
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
                        </div>
                    </div>

                    <div class="mb-0">
                        <strong>Deskripsi:</strong><br>
                        <p class="text-justify mb-0">{{ $pengaduan->deskripsi }}</p>
                    </div>

                    @if ($pengaduan->tanggal_selesai)
                        <div class="mt-3">
                            <strong>Tanggal Selesai:</strong><br>
                            {{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            @if ($pengaduan->catatan_admin)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fs-6">Catatan dari Admin</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-justify mb-0">{{ $pengaduan->catatan_admin }}</p>
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fs-6">Timeline Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 fw-bold text-dark">Pengaduan Diterima</h6>
                                <p class="text-muted small mb-0">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($pengaduan->status != 'baru')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Pengaduan Diproses</h6>
                                    <p class="text-muted small mb-0">Sedang ditangani oleh admin desa</p>
                                </div>
                            </div>
                        @endif

                        @if ($pengaduan->status == 'selesai')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Pengaduan Selesai</h6>
                                    <p class="text-muted small mb-0">{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif ($pengaduan->status == 'ditolak')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Pengaduan Ditolak</h6>
                                    <p class="text-muted small mb-0">{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if ($pengaduan->status == 'baru')
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fs-6">Aksi</h5>
                    </div>
                    <div class="card-body text-center p-3">
                        <a href="{{ route('masyarakat.pengaduan.edit', $pengaduan) }}" class="btn btn-warning text-dark w-100 mb-2" style="border-radius: 6px;">
                            <i class="fas fa-edit"></i> Edit Pengaduan
                        </a>
                        <form action="{{ route('masyarakat.pengaduan.destroy', $pengaduan) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" style="border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                <i class="fas fa-trash"></i> Hapus Pengaduan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fs-6">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-2"><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
