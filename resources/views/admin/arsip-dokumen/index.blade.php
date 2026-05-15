@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        @include('admin.partials.header')

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1>Kelola Arsip Dokumen</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-archive"></i> Daftar Arsip Dokumen</h5>
                    <a href="{{ route('admin.arsip-dokumen.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Arsip
                    </a>
                </div>
                <div class="card-body">
                    @if($arsips->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Nomor Dokumen</th>
                                        <th>Kategori</th>
                                        <th>Tanggal Dokumen</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($arsips as $index => $arsip)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $arsip->nama_dokumen }}</strong>
                                            @if($arsip->deskripsi)
                                                <br><small class="text-muted">{{ Str::limit($arsip->deskripsi, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $arsip->nomor_dokumen ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($arsip->kategori) }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($arsip->tanggal_dokumen)->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-{{ $arsip->file_type == 'pdf' ? 'pdf' : 'alt' }} text-danger me-2"></i>
                                                <small>{{ strtoupper($arsip->file_type) }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-success" onclick="downloadArsip({{ $arsip->id }})">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                                <button class="btn btn-sm btn-info" onclick="viewArsip({{ $arsip->id }})">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteArsip({{ $arsip->id }})">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-archive fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada arsip dokumen.</p>
                            <a href="{{ route('admin.arsip-dokumen.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Arsip Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<script>
function downloadArsip(id) {
    window.open('/admin/arsip-dokumen/download/' + id, '_blank');
}

function viewArsip(id) {
    alert('Detail arsip ID: ' + id);
}

function deleteArsip(id) {
    if(confirm('Yakin ingin menghapus arsip dokumen ini?')) {
        alert('Hapus arsip ID: ' + id);
    }
}
</script>
@endsection