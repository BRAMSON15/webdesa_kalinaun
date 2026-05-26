@extends('layouts.app')

@section('title', 'Pendaftaran Bansos Saya')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-list"></i> Pendaftaran Bansos Saya</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('masyarakat.bansos.index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Lihat Program
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

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pendaftaran</h5>
                    <h2 class="text-primary">{{ $applications->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="text-warning">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'menunggu')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Disetujui</h5>
                    <h2 class="text-success">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Ditolak</h5>
                    <h2 class="text-danger">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'ditolak')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Pendaftaran</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Program Bansos</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $index => $app)
                        <tr>
                            <td>{{ $applications->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $app->bansos->nama_bansos }}</strong><br>
                                <small class="text-muted">{{ $app->bansos->jenis_bansos }}</small>
                            </td>
                            <td>{{ $app->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @switch($app->status)
                                    @case('menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                        @break
                                    @case('disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if ($app->nominal_diterima)
                                    Rp {{ number_format($app->nominal_diterima, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('masyarakat.bansos.application-detail', $app) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($app->status == 'menunggu')
                                    <form action="{{ route('masyarakat.bansos.cancel-application', $app) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan pendaftaran?')" title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Anda belum mendaftar program bansos apapun
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
