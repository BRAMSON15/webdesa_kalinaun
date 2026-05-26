@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="wrapper" style="height: auto; min-height: 100%;">

    @include('admin.partials.header')

    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Analytics & Laporan
                <small>Dashboard statistik lengkap</small>
            </h1>
        </section>

        <section class="dashboard-content">
            <!-- Date Range Filter -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Periode</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.analytics') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="start_date" class="mr-2">Dari Tanggal:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="form-group mr-3">
                            <label for="end_date" class="mr-2">Sampai Tanggal:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.analytics') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div style="display: flex; flex-wrap: wrap; margin: -10px;">
                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $stats['total_pengaduan'] ?? 0 }}</h3>
                            <p>Total Pengaduan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-comments"></i>
                        </div>
                    </div>
                </div>

                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $stats['pengaduan_selesai'] ?? 0 }}</h3>
                            <p>Pengaduan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $stats['total_bansos'] ?? 0 }}</h3>
                            <p>Program Bansos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hand-holding-heart"></i>
                        </div>
                    </div>
                </div>

                <div style="width: 25%; padding: 10px; min-width: 200px;">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $stats['total_penerima_bansos'] ?? 0 }}</h3>
                            <p>Penerima Bansos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div style="display: flex; flex-wrap: wrap; margin: 10px -10px;">
                <!-- Pengaduan Status Chart -->
                <div style="width: 50%; padding: 10px; min-width: 300px;">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart"></i>
                            <h3 class="box-title">Status Pengaduan</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="pengaduanChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pengaduan Category Chart -->
                <div style="width: 50%; padding: 10px; min-width: 300px;">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <i class="fa fa-pie-chart"></i>
                            <h3 class="box-title">Kategori Pengaduan</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="kategoriChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bansos Status Chart -->
                <div style="width: 50%; padding: 10px; min-width: 300px;">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart"></i>
                            <h3 class="box-title">Status Penerima Bansos</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="bansosChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pengajuan Status Chart -->
                <div style="width: 50%; padding: 10px; min-width: 300px;">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart"></i>
                            <h3 class="box-title">Status Pengajuan Surat</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="pengajuanChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Buttons -->
            <div style="display: flex; flex-wrap: wrap; margin: 10px -10px;">
                <div style="width: 100%; padding: 10px;">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-download"></i>
                            <h3 class="box-title">Export Data</h3>
                        </div>
                        <div class="box-body">
                            <a href="{{ route('admin.export.pengaduan', request()->query()) }}" class="btn btn-primary">
                                <i class="fa fa-download"></i> Export Pengaduan
                            </a>
                            <a href="{{ route('admin.export.bansos', request()->query()) }}" class="btn btn-success">
                                <i class="fa fa-download"></i> Export Bansos
                            </a>
                            <a href="{{ route('admin.export.penerima-bansos', request()->query()) }}" class="btn btn-info">
                                <i class="fa fa-download"></i> Export Penerima Bansos
                            </a>
                            <a href="{{ route('admin.export.pengajuan-surat', request()->query()) }}" class="btn btn-warning">
                                <i class="fa fa-download"></i> Export Pengajuan Surat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    // Pengaduan Status Chart
    const pengaduanCtx = document.getElementById('pengaduanChart').getContext('2d');
    new Chart(pengaduanCtx, {
        type: 'bar',
        data: {
            labels: ['Baru', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: [
                    {{ $chartData['pengaduan_baru'] ?? 0 }},
                    {{ $chartData['pengaduan_diproses'] ?? 0 }},
                    {{ $chartData['pengaduan_selesai'] ?? 0 }},
                    {{ $chartData['pengaduan_ditolak'] ?? 0 }}
                ],
                backgroundColor: [
                    '#FFC107',
                    '#17A2B8',
                    '#28A745',
                    '#DC3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Kategori Chart
    const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
    new Chart(kategoriCtx, {
        type: 'doughnut',
        data: {
            labels: ['Layanan', 'Infrastruktur', 'Kesehatan', 'Pendidikan', 'Lainnya'],
            datasets: [{
                data: [
                    {{ $chartData['kategori_layanan'] ?? 0 }},
                    {{ $chartData['kategori_infrastruktur'] ?? 0 }},
                    {{ $chartData['kategori_kesehatan'] ?? 0 }},
                    {{ $chartData['kategori_pendidikan'] ?? 0 }},
                    {{ $chartData['kategori_lainnya'] ?? 0 }}
                ],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Bansos Status Chart
    const bansosCtx = document.getElementById('bansosChart').getContext('2d');
    new Chart(bansosCtx, {
        type: 'bar',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Ditolak'],
            datasets: [{
                label: 'Jumlah Penerima',
                data: [
                    {{ $chartData['bansos_menunggu'] ?? 0 }},
                    {{ $chartData['bansos_disetujui'] ?? 0 }},
                    {{ $chartData['bansos_ditolak'] ?? 0 }}
                ],
                backgroundColor: [
                    '#FFC107',
                    '#28A745',
                    '#DC3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pengajuan Status Chart
    const pengajuanCtx = document.getElementById('pengajuanChart').getContext('2d');
    new Chart(pengajuanCtx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Disetujui', 'Ditolak'],
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: [
                    {{ $chartData['pengajuan_pending'] ?? 0 }},
                    {{ $chartData['pengajuan_disetujui'] ?? 0 }},
                    {{ $chartData['pengajuan_ditolak'] ?? 0 }}
                ],
                backgroundColor: [
                    '#FFC107',
                    '#28A745',
                    '#DC3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
