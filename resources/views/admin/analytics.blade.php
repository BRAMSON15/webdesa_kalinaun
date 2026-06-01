@extends('layouts.sipakal')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<link rel="stylesheet" href="{{ asset('css/analytics.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css">
<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>
    <div class="dashboard-main">
        @include('admin.partials.header')
        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1><i class="fas fa-chart-line me-2"></i>Analytics & Reporting</h1>
            </div>
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <!-- Pengaduan Stats -->
                <div class="stat-card">
                    <h3>Total Pengaduan</h3>
                    <p class="value">{{ $pengaduanStats['total'] }}</p>
                    <p class="subtitle">Semua pengaduan</p>
                </div>
                <div class="stat-card success">
                    <h3>Pengaduan Selesai</h3>
                    <p class="value">{{ $pengaduanStats['selesai'] }}</p>
                    <p class="subtitle">{{ round(($pengaduanStats['selesai'] / max($pengaduanStats['total'], 1)) * 100) }}% dari total</p>
                </div>
                <div class="stat-card warning">
                    <h3>Pengaduan Diproses</h3>
                    <p class="value">{{ $pengaduanStats['diproses'] }}</p>
                    <p class="subtitle">Sedang ditangani</p>
                </div>
                <div class="stat-card danger">
                    <h3>Pengaduan Ditolak</h3>
                    <p class="value">{{ $pengaduanStats['ditolak'] }}</p>
                    <p class="subtitle">Tidak dapat diproses</p>
                </div>
                <!-- Bansos Stats -->
                <div class="stat-card info">
                    <h3>Program Bansos</h3>
                    <p class="value">{{ $bansosStats['total_program'] }}</p>
                    <p class="subtitle">{{ $bansosStats['program_aktif'] }} aktif</p>
                </div>
                <div class="stat-card success">
                    <h3>Total Penerima</h3>
                    <p class="value">{{ $bansosStats['total_penerima'] }}</p>
                    <p class="subtitle">{{ $bansosStats['penerima_disetujui'] }} disetujui</p>
                </div>
                <!-- Pengajuan Stats -->
                <div class="stat-card">
                    <h3>Pengajuan Surat</h3>
                    <p class="value">{{ $pengajuanStats['total'] }}</p>
                    <p class="subtitle">Semua pengajuan</p>
                </div>
                <div class="stat-card success">
                    <h3>Surat Disetujui</h3>
                    <p class="value">{{ $pengajuanStats['disetujui'] }}</p>
                    <p class="subtitle">Selesai diproses</p>
                </div>
                <!-- User Stats -->
                <div class="stat-card info">
                    <h3>Total Pengguna</h3>
                    <p class="value">{{ $userStats['total_user'] }}</p>
                    <p class="subtitle">{{ $userStats['masyarakat'] }} masyarakat</p>
                </div>
            </div>
            <!-- Charts -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-pie me-2"></i>Pengaduan by Kategori</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="pengaduanKategoriChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-pie me-2"></i>Pengaduan by Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="pengaduanStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top Programs -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-star me-2"></i>Top 5 Program Bansos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program</th>
                                    <th>Penerima</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPrograms as $index => $program)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $program->nama_bansos }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $program->penerima_count }}</span>
                                    </td>
                                    <td>Rp {{ number_format($program->nominal, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Export Options -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-download me-2"></i>Export Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.pengaduan', ['format' => 'csv']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-csv me-2"></i>Pengaduan CSV
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.pengaduan', ['format' => 'pdf']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-pdf me-2"></i>Pengaduan PDF
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.bansos', ['format' => 'csv']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-csv me-2"></i>Bansos CSV
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.bansos', ['format' => 'pdf']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-pdf me-2"></i>Bansos PDF
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.penerima-bansos', ['format' => 'csv']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-csv me-2"></i>Penerima CSV
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.penerima-bansos', ['format' => 'pdf']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-pdf me-2"></i>Penerima PDF
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.pengajuan-surat', ['format' => 'csv']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-csv me-2"></i>Surat CSV
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.export.pengajuan-surat', ['format' => 'pdf']) }}" class="btn btn-export w-100">
                                <i class="fas fa-file-pdf me-2"></i>Surat PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
// Pengaduan by Kategori Chart
const pengaduanKategoriCtx = document.getElementById('pengaduanKategoriChart').getContext('2d');
new Chart(pengaduanKategoriCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($pengaduanByKategori as $item)
                '{{ ucfirst($item->kategori) }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($pengaduanByKategori as $item)
                    {{ $item->total }},
                @endforeach
            ],
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#f093fb',
                '#4facfe',
                '#00f2fe',
                '#43e97b',
                '#fa709a',
                '#fee140',
            ],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
// Pengaduan by Status Chart
const pengaduanStatusCtx = document.getElementById('pengaduanStatusChart').getContext('2d');
new Chart(pengaduanStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Baru', 'Diproses', 'Selesai', 'Ditolak'],
        datasets: [{
            data: [
                {{ $pengaduanStats['baru'] }},
                {{ $pengaduanStats['diproses'] }},
                {{ $pengaduanStats['selesai'] }},
                {{ $pengaduanStats['ditolak'] }},
            ],
            backgroundColor: [
                '#17a2b8',
                '#ffc107',
                '#28a745',
                '#dc3545',
            ],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
@endsection
