@extends('layouts.sipakal')
@section('title', 'Dashboard Kades')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardkades.css') }}">
<div class="wrapper" style="height: auto; min-height: 100%;">
    @include('Kades.partials.header')
    @include('Kades.partials.sidebar')
    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Dashboard Kades
                <small>Control panel</small>
            </h1>
        </section>
        <section class="dashboard-content">
            <!-- Small boxes (Stat box) -->
            <div style="display: flex; flex-wrap: wrap; margin: -10px;">
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $stats['total_pengajuan'] ?? 0 }}</h3>
                            <p>Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $stats['pengajuan_pending'] ?? 0 }}</h3>
                            <p>Menunggu Validasi</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock"></i>
                        </div>
                        <a href="{{ route('kades.validasi-pengajuan') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $stats['pengajuan_disetujui'] ?? 0 }}</h3>
                            <p>Disetujui</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $stats['pengajuan_ditolak'] ?? 0 }}</h3>
                            <p>Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-times"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-purple" style="background-color: #605ca8; color: white;">
                        <div class="inner">
                            <h3>{{ $stats['bansos_pending'] ?? 0 }}</h3>
                            <p>Bansos Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hand-holding-heart"></i>
                        </div>
                        <a href="{{ route('kades.validasi-bansos') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Main row / Pending Validation List -->
            @if(isset($pengajuanTerbaru) && $pengajuanTerbaru->count() > 0)
            <div style="display: flex; flex-wrap: wrap; margin: 10px -10px;">
                <div style="width: 100%; padding: 10px;">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <i class="fa fa-clock"></i>
                            <h3 class="box-title">Pengajuan Surat Menunggu Validasi</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pemohon</th>
                                            <th>Jenis Surat</th>
                                            <th>Keperluan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengajuanTerbaru as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $pengajuan->user->name }}</td>
                                            <td>{{ $pengajuan->jenisSurat->nama_surat }}</td>
                                            <td>{{ Str::limit($pengajuan->keperluan, 50) }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Bansos Pending Validation List -->
            @if(isset($bansosTerbaru) && $bansosTerbaru->count() > 0)
            <div style="display: flex; flex-wrap: wrap; margin: 10px -10px;">
                <div style="width: 100%; padding: 10px;">
                    <div class="box box-danger" style="border-top-color: #dd4b39;">
                        <div class="box-header with-border">
                            <i class="fa fa-hand-holding-heart text-danger"></i>
                            <h3 class="box-title">Permintaan Bansos Menunggu Validasi</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pendaftar</th>
                                            <th>NIK</th>
                                            <th>Program Bansos</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bansosTerbaru as $penerima)
                                        <tr>
                                            <td>{{ $penerima->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $penerima->nama_penerima }}</td>
                                            <td>{{ $penerima->nik }}</td>
                                            <td>{{ $penerima->bansos->nama_program }}</td>
                                            <td>
                                                <a href="{{ route('kades.validasi-bansos') }}" 
                                                   class="btn btn-sm btn-warning text-dark">
                                                    <i class="fas fa-check-circle"></i> Proses Validasi
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>
</div>
@include('Kades.partials.scripts')
@endsection