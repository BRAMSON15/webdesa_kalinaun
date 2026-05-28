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

    .persyaratan-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .persyaratan-list li {
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-left: 4px solid #667eea;
        margin-bottom: 0.5rem;
        border-radius: 0.25rem;
    }

    .persyaratan-list li:before {
        content: "✓ ";
        color: #667eea;
        font-weight: bold;
        margin-right: 0.5rem;
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
                <h1><i class="fas fa-file-alt me-2"></i>Detail Jenis Surat</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informasi Jenis Surat</h5>
                </div>
                <div class="card-body">
                    <div class="detail-section">
                        <span class="detail-label">Nama Surat</span>
                        <div class="detail-value">
                            <strong>{{ $jenisSurat->nama_surat }}</strong>
                        </div>
                    </div>

                    <div class="detail-section">
                        <span class="detail-label">Deskripsi</span>
                        <div class="detail-value">
                            {{ $jenisSurat->deskripsi ?? 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    <div class="detail-section">
                        <span class="detail-label">Status</span>
                        <div class="detail-value">
                            @if($jenisSurat->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    @if($jenisSurat->persyaratan && count($jenisSurat->persyaratan) > 0)
                    <div class="detail-section">
                        <span class="detail-label">Persyaratan</span>
                        <ul class="persyaratan-list">
                            @foreach($jenisSurat->persyaratan as $persyaratan)
                                <li>{{ $persyaratan }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="detail-section">
                        <span class="detail-label">Tanggal Dibuat</span>
                        <div class="detail-value">
                            {{ $jenisSurat->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="detail-section">
                        <span class="detail-label">Terakhir Diperbarui</span>
                        <div class="detail-value">
                            {{ $jenisSurat->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('admin.jenis-surat.edit', $jenisSurat->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.jenis-surat') }}" class="btn btn-secondary">
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
