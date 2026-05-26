@extends('layouts.app')

@section('title', 'Kelola Penerima Bansos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Kelola Penerima - {{ $bansos->nama_bansos }}</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.bansos.show', $bansos) }}" class="btn btn-secondary">
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

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $penerima->total() }}</h3>
                    <p class="text-muted mb-0">Total Pendaftar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $penerima->where('status', 'disetujui')->count() }}</h3>
                    <p class="text-muted mb-0">Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ $penerima->where('status', 'menunggu')->count() }}</h3>
                    <p class="text-muted mb-0">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-danger">{{ $penerima->where('status', 'ditolak')->count() }}</h3>
                    <p class="text-muted mb-0">Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Penerima -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Penerima</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Penerima</th>
                        <th>NIK</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th>Nominal</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penerima as $index => $item)
                        <tr>
                            <td>{{ $penerima->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $item->nama_penerima }}</strong><br>
                                <small class="text-muted">{{ $item->user->name ?? '-' }}</small>
                            </td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>
                                @switch($item->status)
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
                                @if ($item->nominal_diterima)
                                    Rp {{ number_format($item->nominal_diterima, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($item->status == 'menunggu')
                                    <form action="{{ route('admin.bansos.approve-penerima', ['bansos' => $bansos->id, 'penerima' => $item->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $item->id }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        @if ($item->status == 'menunggu')
                            <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Penerima</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.bansos.reject-penerima', ['bansos' => $bansos->id, 'penerima' => $item->id]) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="alasan">Alasan Penolakan:</label>
                                                    <textarea name="alasan_penolakan" class="form-control" rows="4" required placeholder="Masukkan alasan penolakan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tidak ada penerima
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $penerima->links() }}
        </div>
    </div>
</div>
@endsection
