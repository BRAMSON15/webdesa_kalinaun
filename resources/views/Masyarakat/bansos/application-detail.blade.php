@extends('layouts.masyarakat')

@section('title', 'Detail Pendaftaran Bansos')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-file-alt me-2"></i> Detail Pendaftaran Bansos</h2>
        <div>
            <a href="{{ route('masyarakat.bansos.applications') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <!-- Detail Program -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fs-6">Program Bansos</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Nama Program:</strong><br>
                            {{ $penerima->bansos->nama_bansos }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Jenis:</strong><br>
                            {{ $penerima->bansos->jenis_bansos }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Periode:</strong><br>
                            {{ $penerima->bansos->tanggal_mulai->format('d/m/Y') }} - {{ $penerima->bansos->tanggal_selesai->format('d/m/Y') }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Nominal Program:</strong><br>
                            @if ($penerima->bansos->nominal)
                                Rp {{ number_format($penerima->bansos->nominal, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="mb-0">
                        <strong>Deskripsi:</strong><br>
                        <p class="text-justify mb-0">{{ Str::limit($penerima->bansos->deskripsi, 200) }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pendaftaran -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fs-6">Data Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Nama Penerima:</strong><br>
                            {{ $penerima->nama_penerima }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>NIK:</strong><br>
                            {{ $penerima->nik }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>No. HP:</strong><br>
                            {{ $penerima->no_hp ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Alamat:</strong><br>
                            {{ $penerima->alamat }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Tanggal Pendaftaran:</strong><br>
                            {{ $penerima->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong><br>
                            @switch($penerima->status)
                                @case('menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @break
                                @case('disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    @if ($penerima->status == 'disetujui')
                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <strong>Nominal Diterima:</strong><br>
                                @if ($penerima->nominal_diterima)
                                    Rp {{ number_format($penerima->nominal_diterima, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Tanggal Penerimaan:</strong><br>
                                {{ $penerima->tanggal_penerimaan ? $penerima->tanggal_penerimaan->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    @elseif ($penerima->status == 'ditolak')
                        <div class="mb-3">
                            <strong>Alasan Penolakan:</strong><br>
                            <div class="alert alert-danger py-2 px-3 mt-1 mb-0">
                                {{ $penerima->alasan_penolakan }}
                            </div>
                        </div>
                    @endif

                    @if ($penerima->catatan)
                        <div class="mb-0">
                            <strong>Catatan:</strong><br>
                            {{ $penerima->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fs-6">Timeline Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 fw-bold text-dark">Pendaftaran Diterima</h6>
                                <p class="text-muted small mb-0">{{ $penerima->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($penerima->status == 'disetujui')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Pendaftaran Disetujui</h6>
                                    <p class="text-muted small mb-0">Anda telah diterima sebagai penerima bansos</p>
                                </div>
                            </div>
                        @elseif ($penerima->status == 'ditolak')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Pendaftaran Ditolak</h6>
                                    <p class="text-muted small mb-0">Pendaftaran Anda tidak dapat disetujui</p>
                                </div>
                            </div>
                        @else
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 fw-bold text-dark">Menunggu Verifikasi</h6>
                                    <p class="text-muted small mb-0">Admin sedang memverifikasi pendaftaran Anda</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if ($penerima->status == 'menunggu')
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fs-6">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('masyarakat.bansos.cancel-application', $penerima) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                                <i class="fas fa-times"></i> Batalkan Pendaftaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fs-6">Informasi</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>ID Pendaftaran:</strong><br>#{{ str_pad($penerima->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-2"><strong>Dibuat:</strong><br>{{ $penerima->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Terakhir Diubah:</strong><br>{{ $penerima->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
