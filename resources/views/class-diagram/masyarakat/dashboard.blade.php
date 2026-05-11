@extends('layouts.app')

@section('title', 'Dashboard Masyarakat - Class Diagram')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard Masyarakat (Class Diagram)</h2>
            <p class="text-muted">Selamat datang, {{ auth('masyarakat')->user()->nama }}</p>
            <hr>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_pengajuan'] }}</h4>
                            <p class="mb-0">Total Pengajuan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['pengajuan_proses'] }}</h4>
                            <p class="mb-0">Sedang Diproses</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['pengajuan_selesai'] }}</h4>
                            <p class="mb-0">Selesai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['pengajuan_ditolak'] }}</h4>
                            <p class="mb-0">Ditolak</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5>Buat Pengajuan Surat</h5>
                    <p class="text-muted">Ajukan surat keterangan sesuai kebutuhan</p>
                    <a href="{{ route('class-diagram.masyarakat.form-pengajuan') }}" class="btn btn-primary">Buat Pengajuan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-history fa-3x text-success mb-3"></i>
                    <h5>Riwayat Pengajuan</h5>
                    <p class="text-muted">Lihat status dan riwayat pengajuan Anda</p>
                    <a href="{{ route('class-diagram.masyarakat.riwayat-pengajuan') }}" class="btn btn-success">Lihat Riwayat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user fa-3x text-info mb-3"></i>
                    <h5>Profil Saya</h5>
                    <p class="text-muted">Kelola profil dan data pribadi Anda</p>
                    <a href="{{ route('class-diagram.masyarakat.profil') }}" class="btn btn-info">Kelola Profil</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file-alt"></i> Pengajuan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($pengajuanTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Surat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengajuanTerbaru as $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                                        <td>{{ $pengajuan->jenis_surat }}</td>
                                        <td>{!! $pengajuan->status_badge !!}</td>
                                        <td>
                                            <a href="{{ route('class-diagram.masyarakat.cek-status', $pengajuan->id_surat) }}" 
                                               class="btn btn-sm btn-outline-primary">Cek Status</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada pengajuan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection