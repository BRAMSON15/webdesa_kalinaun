@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<!-- Full AdminLTE Structure -->
<div class="wrapper" style="height: auto; min-height: 100%;">

    <header class="main-header">
        <a href="" class="logo"><b>Desa</b>Kalinaun</a>
        <nav class="navbar">
            <a href="#" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </a>
            <div class="navbar-right">
                <img src="https://via.placeholder.com/160" alt="User Image">
                <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </nav>
    </header>

    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
        </section>

        <section class="dashboard-content">
            <!-- Small boxes (Stat box) -->
            <div style="display: flex; flex-wrap: wrap; margin: -10px;">
                
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $stats['pengajuan_pending'] ?? 0 }}</h3>
                            <p>Pengajuan Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <a href="{{ route('admin.pengajuan-surat') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $stats['total_pengajuan'] ?? 0 }}</h3>
                            <p>Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-chart-bar"></i>
                        </div>
                        <a href="{{ route('admin.pengajuan-surat') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $stats['total_users'] ?? 0 }}</h3>
                            <p>Total Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="{{ route('admin.data-pengguna') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $stats['total_informasi'] ?? 0 }}</h3>
                            <p>Total Informasi</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('admin.informasi-desa') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <!-- Main row -->
            <div style="display: flex; flex-wrap: wrap; margin: 10px -10px;">
                <div style="width: 60%; padding: 10px; min-width: 300px;">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-comments"></i>
                            <h3 class="box-title">Pengajuan Terbaru</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jenis Surat</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($pengajuanTerbaru) && count($pengajuanTerbaru) > 0)
                                        @foreach($pengajuanTerbaru->take(5) as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->user->name ?? 'Warga' }}</td>
                                            <td>{{ $pengajuan->jenisSurat->nama_surat ?? 'Pengajuan Surat' }}</td>
                                            <td>
                                                <span class="label {{ $pengajuan->status == 'pending' ? 'label-warning' : ($pengajuan->status == 'disetujui' ? 'label-success' : 'label-danger') }}">
                                                    {{ ucfirst($pengajuan->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $pengajuan->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada pengajuan</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
@endsection