@extends('layouts.sipakal')
@section('title', 'Validasi Permintaan Bansos')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardkades.css') }}">
<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('Kades.partials.header')
    @include('Kades.partials.sidebar')
    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Validasi Permintaan Bansos
                <small>Daftar pendaftaran bansos yang menunggu validasi Kepala Desa</small>
            </h1>
        </section>
        <section class="dashboard-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="box box-danger" style="border-top-color: #dd4b39;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fas fa-hand-holding-heart text-danger"></i> Daftar Permintaan Bansos</h3>
                </div>
                <div class="box-body">
                    @if($penerimas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Pendaftar</th>
                                    <th>NIK / No. HP</th>
                                    <th>Alamat</th>
                                    <th>Program Bansos</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penerimas as $index => $penerima)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $penerima->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $penerima->nama_penerima }}</strong><br>
                                        <small class="text-muted">Akun: {{ $penerima->user->name ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $penerima->nik }}</div>
                                        <div class="text-muted small"><i class="fas fa-phone-alt"></i> {{ $penerima->no_hp }}</div>
                                    </td>
                                    <td>{{ Str::limit($penerima->alamat, 40) }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $penerima->bansos->nama_program }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Tombol Setujui -->
                                            <form action="{{ route('kades.bansos.approve-penerima', ['bansos' => $penerima->bansos_id, 'penerima' => $penerima->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-success" onclick="if(confirm('Setujui permintaan bansos ini?')) this.form.submit()">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            </form>
                                            
                                            <!-- Tombol Tolak Modal -->
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak-{{ $penerima->id }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>

                                        <!-- Modal Penolakan -->
                                        <div class="modal fade text-start" id="modalTolak-{{ $penerima->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Tolak Permintaan Bansos</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('kades.bansos.reject-penerima', ['bansos' => $penerima->bansos_id, 'penerima' => $penerima->id]) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Pendaftar</label>
                                                                <input type="text" class="form-control" value="{{ $penerima->nama_penerima }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                <textarea name="alasan_penolakan" class="form-control" rows="3" required placeholder="Jelaskan alasan mengapa permohonan ini ditolak (misal: Tidak memenuhi kriteria)"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak Permohonan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-hand-holding-heart fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h5 class="text-muted">Belum ada permintaan bansos</h5>
                        <p class="text-muted">Tidak ada permintaan yang menunggu validasi</p>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@include('Kades.partials.scripts')
@endsection
