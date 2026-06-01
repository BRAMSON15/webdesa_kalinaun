@extends('layouts.sipakal')
@section('title', 'Kelola Penerima Bansos')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('admin.partials.header')
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>
    <div class="dashboard-main">
        <section class="dashboard-header d-flex justify-content-between align-items-center flex-wrap">
            <h1>
                Kelola Penerima
                <small class="text-muted fs-6">{{ $bansos->nama_bansos }}</small>
            </h1>
            <div class="mt-2 mt-md-0">
                <a href="{{ route('admin.bansos.show', $bansos) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </section>
        <section class="dashboard-content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h3 class="text-primary fw-bold">{{ $penerima->total() }}</h3>
                                <p class="text-muted mb-0 small">Total Pendaftar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h3 class="text-success fw-bold">{{ $penerima->where('status', 'disetujui')->count() }}</h3>
                                <p class="text-muted mb-0 small">Disetujui</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h3 class="text-warning fw-bold">{{ $penerima->where('status', 'menunggu')->count() }}</h3>
                                <p class="text-muted mb-0 small">Menunggu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h3 class="text-danger fw-bold">{{ $penerima->where('status', 'ditolak')->count() }}</h3>
                                <p class="text-muted mb-0 small">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabel Penerima -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fs-6"><i class="fas fa-list"></i> Daftar Penerima</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
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
                                                        <button type="submit" class="btn btn-sm btn-success text-white me-1" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @elseif ($item->status == 'disetujui' && $item->user && $item->user->no_hp)
                                                    @php
                                                        $waLink = \App\Services\NotificationService::getWhatsAppLinkBansosApproved($item);
                                                    @endphp
                                                    @if ($waLink)
                                                        <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-success" title="Kirim WhatsApp">
                                                            <i class="fab fa-whatsapp"></i> WA
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">No HP kosong</span>
                                                    @endif
                                                @elseif ($item->status == 'ditolak' && $item->user && $item->user->no_hp)
                                                    @php
                                                        $waLink = \App\Services\NotificationService::getWhatsAppLinkBansosRejected($item);
                                                    @endphp
                                                    @if ($waLink)
                                                        <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-danger" title="Kirim WhatsApp">
                                                            <i class="fab fa-whatsapp"></i> WA
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">No HP kosong</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- Reject Modal -->
                                        @if ($item->status == 'menunggu')
                                            <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectModalLabel{{ $item->id }}">Tolak Penerima</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.bansos.reject-penerima', ['bansos' => $bansos->id, 'penerima' => $item->id]) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="alasan{{ $item->id }}" class="form-label">Alasan Penolakan:</label>
                                                                    <textarea name="alasan_penolakan" id="alasan{{ $item->id }}" class="form-control" rows="4" required placeholder="Masukkan alasan penolakan..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Tidak ada penerima
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $penerima->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const mainContent = document.querySelector('.dashboard-main');
        if (sidebarToggle && sidebar && mainContent) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        }
    });
</script>
@endsection
