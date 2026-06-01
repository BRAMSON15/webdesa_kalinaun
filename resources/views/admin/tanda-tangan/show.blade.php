@extends('layouts.sipakal')
@section('title', 'Detail Tanda Tangan')
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
                <h1><i class="fas fa-info-circle me-2"></i>Detail Tanda Tangan</h1>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-file-alt"></i> Informasi Pejabat</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Nama Pejabat:</span>
                                <span class="info-value"><strong>{{ $tandaTangan->nama_pejabat }}</strong></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jabatan:</span>
                                <span class="info-value">{{ $tandaTangan->jabatan }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">NIP:</span>
                                <span class="info-value">{{ $tandaTangan->nip ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="info-value">
                                    @if($tandaTangan->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ditambahkan:</span>
                                <span class="info-value">{{ $tandaTangan->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($tandaTangan->keterangan)
                                <div style="padding: 1rem 0; border-top: 1px solid #dee2e6;">
                                    <strong class="d-block mb-2">Keterangan:</strong>
                                    <p class="mb-0">{{ $tandaTangan->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <h5><i class="fas fa-signature"></i> Tanda Tangan</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="signature-display">
                                <img src="{{ asset('storage/' . $tandaTangan->signature_path) }}" alt="Tanda Tangan">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.tanda-tangan.edit', $tandaTangan) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.tanda-tangan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
