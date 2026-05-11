<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Arsip - SIPAKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardkades.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        @include('Kades.partials.header')
        @include('Kades.partials.sidebar')
        
        <div class="dashboard-main">
            <div class="dashboard-content">

                <div class="container-fluid mt-4">
                <!-- Filter & Export Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form method="GET" action="{{ route('kades.laporan-arsip') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <select class="form-select" id="bulan" name="bulan">
                                            <option value="">Semua Bulan</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <select class="form-select" id="tahun" name="tahun">
                                            <option value="">Semua Tahun</option>
                                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('kades.laporan-arsip') }}" class="btn btn-secondary">
                                            <i class="fas fa-redo"></i> Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 d-flex align-items-end justify-content-end">
                                <button onclick="window.print()" class="btn btn-success">
                                    <i class="fas fa-print"></i> Cetak Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-primary shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Arsip</h6>
                                        <h2 class="mb-0">{{ $pengajuans->count() }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-file-archive fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-success shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Disetujui</h6>
                                        <h2 class="mb-0">{{ $pengajuans->where('status', 'disetujui')->count() }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-danger shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Ditolak</h6>
                                        <h2 class="mb-0">{{ $pengajuans->where('status', 'ditolak')->count() }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-times-circle fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Grafik Statistik Pengajuan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPengajuan" height="80"></canvas>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-archive"></i> Daftar Arsip Pengajuan</h5>
                    </div>
                    <div class="card-body">
                        @if($pengajuans->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Nama Pemohon</th>
                                            <th>Jenis Surat</th>
                                            <th>Status</th>
                                            <th>Nomor Surat</th>
                                            <th>Tanggal Proses</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengajuans as $index => $pengajuan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $pengajuan->user->name }}</td>
                                                <td>{{ $pengajuan->jenisSurat->nama_surat }}</td>
                                                <td>
                                                    @if($pengajuan->status === 'disetujui')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i> Disetujui
                                                        </span>
                                                    @elseif($pengajuan->status === 'ditolak')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $pengajuan->nomor_surat ?? '-' }}</td>
                                                <td>
                                                    @if($pengajuan->tanggal_disetujui)
                                                        {{ $pengajuan->tanggal_disetujui->format('d/m/Y') }}
                                                    @elseif($pengajuan->tanggal_ditolak)
                                                        {{ $pengajuan->tanggal_ditolak->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('kades.detail-pengajuan', $pengajuan->id) }}" 
                                                       class="btn btn-sm btn-info">
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
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data arsip pengajuan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart
        const ctx = document.getElementById('chartPengajuan').getContext('2d');
        const chartData = {
            labels: ['Disetujui', 'Ditolak'],
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: [
                    {{ $pengajuans->where('status', 'disetujui')->count() }},
                    {{ $pengajuans->where('status', 'ditolak')->count() }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        };

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    @include('Kades.partials.scripts')

    <style>
        @media print {
            .dashboard-sidebar, .main-header, .btn, .no-print {
                display: none !important;
            }
            .dashboard-main {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</body>
</html>
