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
                <h1><i class="fas fa-info-circle me-2"></i>Kelola Informasi Desa</h1>
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
                    <h5><i class="fas fa-list"></i> Daftar Informasi Desa</h5>
                    <a href="{{ route('admin.informasi-desa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Informasi
                    </a>
                </div>
                <div class="card-body">
                    @if($informasis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 30%;">Judul</th>
                                        <th style="width: 15%;">Kategori</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 15%;">Tanggal Dibuat</th>
                                        <th style="width: 25%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($informasis as $index => $informasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ Str::limit($informasi->judul, 40) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($informasi->kategori) }}</span>
                                        </td>
                                        <td>
                                            @if($informasi->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $informasi->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.informasi-desa.show', $informasi->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                                </a>
                                                <a href="{{ route('admin.informasi-desa.edit', $informasi->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                                </a>
                                                <form action="{{ route('admin.informasi-desa.destroy', $informasi->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;" 
                                                      onsubmit="return confirm('Yakin ingin menghapus informasi ini?');">
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
                            <i class="fas fa-inbox"></i>
                            <p class="text-muted">Belum ada informasi desa.</p>
                            <a href="{{ route('admin.informasi-desa.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Informasi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@endsection