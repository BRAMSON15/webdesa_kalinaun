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
                <h1>Kelola Jenis Surat</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-file-alt"></i> Daftar Jenis Surat</h5>
                    <a href="{{ route('admin.jenis-surat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jenis Surat
                    </a>
                </div>
                <div class="card-body">
                    @if($jenisSurats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Surat</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jenisSurats as $index => $jenis)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $jenis->nama_surat }}</strong>
                                        </td>
                                        <td>{{ Str::limit($jenis->deskripsi, 50) }}</td>
                                        <td>
                                            @if($jenis->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $jenis->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info" onclick="viewJenis({{ $jenis->id }})">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="editJenis({{ $jenis->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteJenis({{ $jenis->id }})">
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
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada jenis surat.</p>
                            <a href="{{ route('admin.jenis-surat.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Jenis Surat Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<script>
function viewJenis(id) {
    alert('Detail jenis surat ID: ' + id);
}

function editJenis(id) {
    alert('Edit jenis surat ID: ' + id);
}

function deleteJenis(id) {
    if(confirm('Yakin ingin menghapus jenis surat ini?')) {
        alert('Hapus jenis surat ID: ' + id);
    }
}
</script>
@endsection