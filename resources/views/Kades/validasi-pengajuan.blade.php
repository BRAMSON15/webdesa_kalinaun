@extends('layouts.sipakal')
@section('title', 'Validasi Pengajuan Surat')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardkades.css') }}">
<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('Kades.partials.header')
    @include('Kades.partials.sidebar')
    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Validasi Pengajuan Surat
                <small>Daftar pengajuan yang menunggu validasi</small>
            </h1>
        </section>
        <section class="dashboard-content">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fas fa-check-circle"></i> Daftar Pengajuan</h3>
                </div>
                <div class="box-body">
                    @if($pengajuans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuans as $index => $pengajuan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $pengajuan->user->name }}</strong><br>
                                        <small class="text-muted">{{ $pengajuan->user->nik }}</small>
                                    </td>
                                    <td>{{ $pengajuan->jenisSurat->nama_surat }}</td>
                                    <td>{{ Str::limit($pengajuan->keperluan, 50) }}</td>
                                    <td>
                                        <span class="badge bg-warning" style="padding: 5px 10px;">{{ ucfirst($pengajuan->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('kades.detail-pengajuan', $pengajuan->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h5 class="text-muted">Tidak ada pengajuan yang menunggu validasi</h5>
                        <p class="text-muted">Semua pengajuan sudah diproses</p>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@include('Kades.partials.scripts')
@endsection