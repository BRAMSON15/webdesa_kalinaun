@extends('layouts.masyarakat')

@section('title', 'Pendaftaran Bansos Saya')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="mb-0"><i class="fas fa-list me-2"></i> Pendaftaran Bansos Saya</h2>
        <div class="d-flex gap-2 mt-2 mt-md-0">
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted small">Total Pendaftaran</h5>
                    <h2 class="text-primary fw-bold mb-0">{{ $applications->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted small">Menunggu</h5>
                    <h2 class="text-warning fw-bold mb-0">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'menunggu')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted small">Disetujui</h5>
                    <h2 class="text-success fw-bold mb-0">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted small">Ditolak</h5>
                    <h2 class="text-danger fw-bold mb-0">{{ \App\Models\PenerimaBansos::where('user_id', auth()->id())->where('status', 'ditolak')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fs-6"><i class="fas fa-list"></i> Daftar Pendaftaran</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
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
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                            @break
                                        @case('disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
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
                                    <a href="{{ route('masyarakat.bansos.application-detail', $app) }}" class="btn btn-sm btn-info text-white me-1" title="Lihat Detail">
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
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Anda belum mendaftar program bansos apapun
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
