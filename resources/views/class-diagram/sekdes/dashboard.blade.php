@extends('layouts.app')

@section('title', 'Dashboard Sekdes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard Kepala Desa</h2>
            <p class="text-muted">Selamat datang, {{ auth('sekdes')->user()->username }}</p>
            <hr>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">{{ $stats['total_pengajuan'] }}</h2>
                            <p class="mb-0">Total Pengajuan</p>
                            <small>Semua pengajuan</small>
                        </div>
                        <div>
                            <i class="fas fa-file-alt fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="text-white">
                        <small>More info <i class="fas fa-arrow-circle-right"></i></small>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">{{ $stats['pengajuan_proses'] }}</h2>
                            <p class="mb-0">Menunggu Validasi</p>
                            <small>Perlu diproses</small>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="text-white">
                        <small>More info <i class="fas fa-arrow-circle-right"></i></small>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">{{ $stats['pengajuan_selesai'] }}</h2>
                            <p class="mb-0">Disetujui</p>
                            <small>Sudah selesai</small>
                        </div>
                        <div>
                            <i class="fas fa-check fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('class-diagram.sekdes.laporan-arsip') }}" class="text-white">
                        <small>More info <i class="fas fa-arrow-circle-right"></i></small>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">{{ $stats['pengajuan_ditolak'] }}</h2>
                            <p class="mb-0">Ditolak</p>
                            <small>Tidak disetujui</small>
                        </div>
                        <div>
                            <i class="fas fa-times fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('class-diagram.sekdes.laporan-arsip') }}" class="text-white">
                        <small>More info <i class="fas fa-arrow-circle-right"></i></small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Menunggu Validasi -->
    @if($pengajuanMenunggu->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> Pengajuan Menunggu Validasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pemohon</th>
                                    <th>NIK</th>
                                    <th>Jenis Surat</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanMenunggu as $index => $pengajuan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                                    <td>{{ $pengajuan->masyarakat->nama }}</td>
                                    <td>{{ $pengajuan->masyarakat->nik }}</td>
                                    <td><span class="badge bg-info">{{ $pengajuan->jenis_surat }}</span></td>
                                    <td>{{ Str::limit($pengajuan->keterangan, 50) }}</td>
                                    <td>
                                        <a href="{{ route('class-diagram.sekdes.detail-pengajuan', $pengajuan->id_surat) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="btn btn-warning">
                            <i class="fas fa-list"></i> Lihat Semua Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <h5>Tidak Ada Pengajuan Menunggu Validasi</h5>
                <p class="mb-0">Semua pengajuan sudah diproses</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection