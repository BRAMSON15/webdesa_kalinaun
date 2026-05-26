@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-comments"></i> Detail Pengaduan</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

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

            @if ($pengaduan->catatan_admin)
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Catatan dari Admin</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-justify">{{ $pengaduan->catatan_admin }}</p>
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Timeline Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Pengaduan Diterima</h6>
                                <p class="text-muted">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($pengaduan->status != 'baru')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6>Pengaduan Diproses</h6>
                                    <p class="text-muted">Sedang ditangani oleh admin desa</p>
                                </div>
                            </div>
                        @endif

                        @if ($pengaduan->status == 'selesai')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6>Pengaduan Selesai</h6>
                                    <p class="text-muted">{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif ($pengaduan->status == 'ditolak')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6>Pengaduan Ditolak</h6>
                                    <p class="text-muted">{{ $pengaduan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if ($pengaduan->status == 'baru')
                <div class="card mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('masyarakat.pengaduan.edit', $pengaduan) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit"></i> Edit Pengaduan
                        </a>
                        <form action="{{ route('masyarakat.pengaduan.destroy', $pengaduan) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                <i class="fas fa-trash"></i> Hapus Pengaduan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID Pengaduan:</strong><br>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Dibuat:</strong><br>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 50px;
        width: 2px;
        height: 30px;
        background-color: #e0e0e0;
    }

    .timeline-marker {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .timeline-content h6 {
        margin-bottom: 5px;
    }
</style>
@endsection
