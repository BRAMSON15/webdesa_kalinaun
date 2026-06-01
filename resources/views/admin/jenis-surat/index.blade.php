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
                <h1><i class="fas fa-file-alt me-2"></i>Kelola Jenis Surat</h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Daftar Jenis Surat</h5>
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
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 25%;">Nama Surat</th>
                                        <th style="width: 35%;">Deskripsi</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 10%;">Dibuat</th>
                                        <th style="width: 15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jenisSurats as $index => $jenis)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $jenis->nama_surat }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($jenis->deskripsi, 50) }}</small>
                                        </td>
                                        <td>
                                            @if($jenis->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $jenis->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.jenis-surat.show', $jenis->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                                </a>
                                                <a href="{{ route('admin.jenis-surat.edit', $jenis->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('admin.jenis-surat.destroy', $jenis->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;" 
                                                      onsubmit="return confirm('Yakin ingin menghapus jenis surat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
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
@endsection