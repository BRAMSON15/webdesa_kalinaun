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
                <h1>Kelola Informasi Desa</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-info-circle"></i> Daftar Informasi Desa</h5>
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
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($informasis as $index => $informasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $informasi->judul }}</td>
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
                                        <td>{{ $informasi->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
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
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
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