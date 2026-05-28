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
        padding: 2rem;
    }

    .detail-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .detail-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        color: #2c3e50;
        font-size: 1rem;
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #dee2e6;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(108, 117, 125, 0.3);
    }

    .image-container {
        margin: 1rem 0;
        text-align: center;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .content-box {
        background-color: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        border-radius: 0.5rem;
        line-height: 1.8;
        color: #2c3e50;
    }

    .meta-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
    }

    .meta-label {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .meta-value {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .meta-info {
            grid-template-columns: 1fr;
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
