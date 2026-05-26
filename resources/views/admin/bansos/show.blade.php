@extends('layouts.app')

@section('title', 'Detail Program Bansos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-hand-holding-heart"></i> Detail Program Bansos</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary">
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
        <!-- Detail Program -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Program</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama Program:</strong><br>
                            {{ $bansos->nama_bansos }}
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Bansos:</strong><br>
                            {{ $bansos->jenis_bansos }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Mulai:</strong><br>
                            {{ $bansos->tanggal_mulai->format('d/m/Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Selesai:</strong><br>
                            {{ $bansos->tanggal_selesai->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="row mb-3">
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
                        <div class="col-md-6">
                            <strong>Nominal per Penerima:</strong><br>
                            Rp {{ number_format($bansos->nominal, 0, ',', '.') }}
                        </div>
                    </div>

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
                </div>
            </div>

            <!-- Statistik Penerima -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Statistik Penerima</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <h3 class="text-primary">{{ $statistik['total_penerima'] }}</h3>
                            <p class="text-muted">Total Pendaftar</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h3 class="text-success">{{ $statistik['disetujui'] }}</h3>
                            <p class="text-muted">Disetujui</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h3 class="text-warning">{{ $statistik['menunggu'] }}</h3>
                            <p class="text-muted">Menunggu</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h3 class="text-danger">{{ $statistik['ditolak'] }}</h3>
                            <p class="text-muted">Ditolak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Kuota Program</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Kuota Tersedia:</strong><br>
                        <h4 class="text-primary">{{ $bansos->kuota - $bansos->kuota_terpakai }} / {{ $bansos->kuota }}</h4>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ ($bansos->kuota_terpakai / $bansos->kuota) * 100 }}%;" 
                             aria-valuenow="{{ $bansos->kuota_terpakai }}" 
                             aria-valuemin="0" 
                             aria-valuemax="{{ $bansos->kuota }}">
                            {{ round(($bansos->kuota_terpakai / $bansos->kuota) * 100) }}%
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.bansos.edit', $bansos) }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit Program
                    </a>
                    <a href="{{ route('admin.bansos.manage-penerima', $bansos) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-users"></i> Kelola Penerima
                    </a>
                    <form action="{{ route('admin.bansos.destroy', $bansos) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus program ini?')">
                            <i class="fas fa-trash"></i> Hapus Program
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
