@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <header class="main-header">
            <a href="" class="logo"><b>Desa</b>Kalinaun</a>
            <nav class="navbar">
                <div class="navbar-right">
                    <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                </div>
            </nav>
        </header>

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1>Status Pengajuan & Pengaduan</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file-alt"></i> Daftar Pengajuan Surat</h5>
                </div>
                <div class="card-body">
                    @if($pengajuans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemohon</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengajuans as $index => $pengajuan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pengajuan->user->name ?? 'N/A' }}</td>
                                        <td>{{ $pengajuan->jenisSurat->nama_surat ?? 'N/A' }}</td>
                                        <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($pengajuan->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($pengajuan->status == 'diproses')
                                                <span class="badge bg-info">Diproses</span>
                                            @elseif($pengajuan->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info" onclick="viewDetail({{ $pengajuan->id }})">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                @if($pengajuan->status == 'disetujui')
                                                    <a href="{{ route('admin.cetak-surat', $pengajuan->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pengajuan surat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<script>
function viewDetail(id) {
    // Implement detail view functionality
    alert('Detail pengajuan ID: ' + id);
}
</script>
@endsection