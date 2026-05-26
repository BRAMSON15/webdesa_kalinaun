@extends('layouts.app')

@section('title', $bansos->nama_bansos)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-hand-holding-heart"></i> {{ $bansos->nama_bansos }}</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.bansos.index') }}" class="btn btn-secondary">
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Detail Program -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Program</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Jenis Bansos:</strong><br>
                            {{ $bansos->jenis_bansos }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @switch($bansos->status)
                                @case('aktif')
                                    <span class="badge badge-success">Aktif</span>
                                    @break
                                @case('nonaktif')
                                    <span class="badge badge-warning">Nonaktif</span>
                                    @break
                                @case('selesai')
                                    <span class="badge badge-secondary">Selesai</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Periode:</strong><br>
                            {{ $bansos->tanggal_mulai->format('d/m/Y') }} - {{ $bansos->tanggal_selesai->format('d/m/Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Kuota Tersedia:</strong><br>
                            {{ $bansos->getRemainingQuota() }} dari {{ $bansos->kuota }}
                        </div>
                    </div>

                    @if ($bansos->nominal)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nominal Bantuan:</strong><br>
                                Rp {{ number_format($bansos->nominal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Deskripsi:</strong><br>
                        <p class="text-justify">{{ $bansos->deskripsi }}</p>
                    </div>

                    @if ($bansos->syarat_ketentuan)
                        <div class="mb-3">
                            <strong>Syarat & Ketentuan:</strong><br>
                            <p class="text-justify">{{ $bansos->syarat_ketentuan }}</p>
                        </div>
                    @endif

                    @if ($bansos->catatan)
                        <div class="alert alert-info">
                            <strong>Catatan:</strong><br>
                            {{ $bansos->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kuota Progress -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Status Kuota</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Penerima Terdaftar:</strong><br>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($bansos->kuota_terpakai / $bansos->kuota) * 100 }}%" aria-valuenow="{{ $bansos->kuota_terpakai }}" aria-valuemin="0" aria-valuemax="{{ $bansos->kuota }}">
                                {{ $bansos->kuota_terpakai }}/{{ $bansos->kuota }}
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle"></i> Sisa kuota: <strong>{{ $bansos->getRemainingQuota() }}</strong> orang
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Pendaftaran -->
            @if (!$sudahMendaftar)
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Daftar Sekarang</h5>
                    </div>
                    <div class="card-body">
                        @if ($bansos->hasQuota())
                            <p class="text-muted">Klik tombol di bawah untuk mendaftar program ini</p>
                            <form action="{{ route('masyarakat.bansos.apply', $bansos) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Daftar Sekarang
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-ban"></i> Kuota program ini sudah penuh
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Status Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle"></i> Anda sudah mendaftar program ini
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Penting -->
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Informasi Penting</h5>
                </div>
                <div class="card-body small">
                    <h6>Proses Pendaftaran:</h6>
                    <ol class="pl-3">
                        <li>Daftar program bansos</li>
                        <li>Tunggu verifikasi admin</li>
                        <li>Jika disetujui, terima bantuan</li>
                    </ol>

                    <h6 class="mt-3">Persyaratan Umum:</h6>
                    <ul class="pl-3">
                        <li>Warga desa yang terdaftar</li>
                        <li>Data diri lengkap</li>
                        <li>Memenuhi kriteria program</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
