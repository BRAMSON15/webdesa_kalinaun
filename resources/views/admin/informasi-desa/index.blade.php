@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<style>
    .dashboard-content {
        padding: 2rem;
        background-color: #f8f9fa;
    }

    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0;
        padding: 1.5rem;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .card-header i {
        margin-right: 0.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
    }

    .btn-info {
        background-color: #0dcaf0;
        color: white;
    }

    .btn-info:hover {
        background-color: #0aa2c0;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
        padding: 0.75rem 1.5rem;
    }

    .btn-primary:hover {
        background-color: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(102, 126, 234, 0.3);
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
</style>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection