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
                <h1><i class="fas fa-info-circle me-2"></i>Detail Informasi Desa</h1>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-newspaper"></i> {{ $informasi->judul }}</h5>
                </div>
                <div class="card-body">
                    <!-- Meta Information -->
                    <div class="meta-info">
                        <div class="meta-item">
                            <div class="meta-label">Kategori</div>
                            <div class="meta-value">
                                <span class="badge bg-info">{{ ucfirst($informasi->kategori) }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">
                                <span class="badge bg-{{ $informasi->status === 'published' ? 'success' : 'warning' }}">
                                    {{ $informasi->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Dibuat Oleh</div>
                            <div class="meta-value">{{ $informasi->creator->name ?? 'Admin' }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Tanggal Dibuat</div>
                            <div class="meta-value">{{ $informasi->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <!-- Judul -->
                    <div class="detail-section">
                        <span class="detail-label">Judul</span>
                        <div class="detail-value">
                            <h3>{{ $informasi->judul }}</h3>
                        </div>
                    </div>
                    <!-- Konten -->
                    <div class="detail-section">
                        <span class="detail-label">Konten</span>
                        <div class="content-box">
                            {!! nl2br(e($informasi->konten)) !!}
                        </div>
                    </div>
                    <!-- Gambar -->
                    @if($informasi->gambar)
                    <div class="detail-section">
                        <span class="detail-label">Gambar</span>
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="{{ $informasi->judul }}" class="img-fluid">
                        </div>
                    </div>
                    @endif
                    <!-- Informasi Tambahan -->
                    <div class="detail-section">
                        <span class="detail-label">Informasi Tambahan</span>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Terakhir Diupdate:</strong><br>{{ $informasi->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>ID Informasi:</strong><br>#{{ $informasi->id }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Aksi -->
                    <div class="button-group">
                        <a href="{{ route('admin.informasi-desa.edit', $informasi->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.informasi-desa') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
