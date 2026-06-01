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
@endsection
