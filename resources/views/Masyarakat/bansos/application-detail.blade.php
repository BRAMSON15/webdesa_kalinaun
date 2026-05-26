@extends('layouts.app')

@section('title', 'Detail Pendaftaran Bansos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-file-alt"></i> Detail Pendaftaran Bansos</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.bansos.applications') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Detail Program -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Program Bansos</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama Program:</strong><br>
                            {{ $penerima->bansos->nama_bansos }}
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis:</strong><br>
                            {{ $penerima->bansos->jenis_bansos }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Periode:</strong><br>
                            {{ $penerima->bansos->tanggal_mulai->format('d/m/Y') }} - {{ $penerima->bansos->tanggal_selesai->format('d/m/Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Nominal Program:</strong><br>
                            @if ($penerima->bansos->nominal)
                                Rp {{ number_format($penerima->bansos->nominal, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Deskripsi:</strong><br>
                        <p class="text-justify">{{ Str::limit($penerima->bansos->deskripsi, 200) }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pendaftaran -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Data Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama Penerima:</strong><br>
                            {{ $penerima->nama_penerima }}
                        </div>
                        <div class="col-md-6">
                            <strong>NIK:</strong><br>
                            {{ $penerima->nik }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>No. HP:</strong><br>
                            {{ $penerima->no_hp ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Alamat:</strong><br>
                            {{ $penerima->alamat }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Pendaftaran:</strong><br>
                            {{ $penerima->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @switch($penerima->status)
                                @case('menunggu')
                                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                                    @break
                                @case('disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    @if ($penerima->status == 'disetujui')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nominal Diterima:</strong><br>
                                @if ($penerima->nominal_diterima)
                                    Rp {{ number_format($penerima->nominal_diterima, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal Penerimaan:</strong><br>
                                {{ $penerima->tanggal_penerimaan ? $penerima->tanggal_penerimaan->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    @elseif ($penerima->status == 'ditolak')
                        <div class="mb-3">
                            <strong>Alasan Penolakan:</strong><br>
                            <div class="alert alert-danger">
                                {{ $penerima->alasan_penolakan }}
                            </div>
                        </div>
                    @endif

                    @if ($penerima->catatan)
                        <div class="mb-3">
                            <strong>Catatan:</strong><br>
                            {{ $penerima->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Timeline Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Pendaftaran Diterima</h6>
                                <p class="text-muted">{{ $penerima->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($penerima->status == 'disetujui')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6>Pendaftaran Disetujui</h6>
                                    <p class="text-muted">Anda telah diterima sebagai penerima bansos</p>
                                </div>
                            </div>
                        @elseif ($penerima->status == 'ditolak')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6>Pendaftaran Ditolak</h6>
                                    <p class="text-muted">Pendaftaran Anda tidak dapat disetujui</p>
                                </div>
                            </div>
                        @else
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6>Menunggu Verifikasi</h6>
                                    <p class="text-muted">Admin sedang memverifikasi pendaftaran Anda</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if ($penerima->status == 'menunggu')
                <div class="card mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('masyarakat.bansos.cancel-application', $penerima) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                                <i class="fas fa-times"></i> Batalkan Pendaftaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Informasi</h5>
                </div>
                <div class="card-body small">
                    <p><strong>ID Pendaftaran:</strong><br>#{{ str_pad($penerima->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Dibuat:</strong><br>{{ $penerima->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $penerima->updated_at->format('d/m/Y H:i') }}</p>
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
