@extends('layouts.app')

@section('title', 'Program Bansos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-hand-holding-heart"></i> Program Bantuan Sosial</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.bansos.applications') }}" class="btn btn-info">
                <i class="fas fa-list"></i> Pendaftaran Saya
            </a>
            <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary">
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

    <!-- Program Cards -->
    <div class="row">
        @forelse ($bansos as $program)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $program->nama_bansos }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <i class="fas fa-tag"></i> {{ $program->jenis_bansos }}
                        </p>

                        <p class="mb-2">
                            <strong>Periode:</strong><br>
                            {{ $program->tanggal_mulai->format('d/m/Y') }} - {{ $program->tanggal_selesai->format('d/m/Y') }}
                        </p>

                        <p class="mb-2">
                            <strong>Kuota:</strong><br>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ ($program->kuota_terpakai / $program->kuota) * 100 }}%" aria-valuenow="{{ $program->kuota_terpakai }}" aria-valuemin="0" aria-valuemax="{{ $program->kuota }}">
                                    {{ $program->kuota_terpakai }}/{{ $program->kuota }}
                                </div>
                            </div>
                        </p>

                        @if ($program->nominal)
                            <p class="mb-2">
                                <strong>Nominal:</strong><br>
                                Rp {{ number_format($program->nominal, 0, ',', '.') }}
                            </p>
                        @endif

                        <p class="mb-3">
                            <strong>Deskripsi:</strong><br>
                            <small>{{ Str::limit($program->deskripsi, 100) }}</small>
                        </p>

                        @if ($program->hasQuota())
                            <a href="{{ route('masyarakat.bansos.show', $program) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-info-circle"></i> Lihat Detail & Daftar
                            </a>
                        @else
                            <button class="btn btn-secondary btn-block" disabled>
                                <i class="fas fa-ban"></i> Kuota Penuh
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox"></i> Tidak ada program bansos yang tersedia saat ini
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $bansos->links() }}
        </div>
    </div>
</div>
@endsection
