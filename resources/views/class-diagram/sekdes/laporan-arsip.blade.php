@extends('layouts.app')

@section('title', 'Laporan Arsip Pengajuan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-file-archive"></i> Laporan Arsip Pengajuan Surat</h2>
            <p class="text-muted">Arsip pengajuan surat yang sudah diproses</p>
            <hr>
        </div>
    </div>

    <!-- Filter & Export Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter & Export Laporan</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('class-diagram.sekdes.export-laporan') }}" class="row g-3">
                        <div class="col-md-2">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" id="bulan" name="bulan">
                                <option value="">Semua Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun" name="tahun">
                                <option value="">Semua Tahun</option>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="selesai">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jenis_surat" class="form-label">Jenis Surat</label>
                            <select class="form-select" id="jenis_surat" name="jenis_surat">
                                <option value="">Semua Jenis</option>
                                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                                <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{ $laporanArsip->count() }}</h3>
                            <p class="mb-0">Total Arsip</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-archive fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{ $laporanArsip->where('status', 'selesai')->count() }}</h3>
                            <p class="mb-0">Disetujui</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{ $laporanArsip->where('status', 'ditolak')->count() }}</h3>
                            <p class="mb-0">Ditolak</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times-circle fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{ $laporanArsip->where('tgl_pengajuan', '>=', now()->startOfMonth())->count() }}</h3>
                            <p class="mb-0">Bulan Ini</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table"></i> Daftar Arsip Pengajuan
                    </h5>
                </div>
                <div class="card-body">
                    @if($laporanArsip->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="8%">ID</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Pemohon</th>
                                    <th width="12%">NIK</th>
                                    <th width="15%">Jenis Surat</th>
                                    <th width="20%">Keterangan</th>
                                    <th width="8%">Status</th>
                                    <th width="12%">Diproses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanArsip as $index => $arsip)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><code>#{{ str_pad($arsip->id_surat, 6, '0', STR_PAD_LEFT) }}</code></td>
                                    <td>
                                        <small>
                                            <i class="fas fa-calendar"></i> {{ $arsip->tgl_pengajuan->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $arsip->masyarakat->nama }}</strong><br>
                                        <small class="text-muted">{{ $arsip->masyarakat->email }}</small>
                                    </td>
                                    <td><code>{{ $arsip->masyarakat->nik }}</code></td>
                                    <td><span class="badge bg-info">{{ $arsip->jenis_surat }}</span></td>
                                    <td><small>{{ Str::limit($arsip->keterangan, 50) }}</small></td>
                                    <td>
                                        @if($arsip->status == 'selesai')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $arsip->updated_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-light">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <strong>Total Pengajuan:</strong> {{ $laporanArsip->count() }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Disetujui:</strong> 
                                        <span class="text-success">{{ $laporanArsip->where('status', 'selesai')->count() }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Ditolak:</strong> 
                                        <span class="text-danger">{{ $laporanArsip->where('status', 'ditolak')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Arsip</h5>
                        <p class="text-muted">Arsip akan muncul setelah pengajuan diproses</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Jenis Surat Terpopuler</h5>
                </div>
                <div class="card-body">
                    <canvas id="jenisSuratChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: ['Disetujui', 'Ditolak'],
        datasets: [{
            data: [
                {{ $laporanArsip->where('status', 'selesai')->count() }},
                {{ $laporanArsip->where('status', 'ditolak')->count() }}
            ],
            backgroundColor: ['#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Jenis Surat Chart
const jenisSuratCtx = document.getElementById('jenisSuratChart').getContext('2d');
new Chart(jenisSuratCtx, {
    type: 'bar',
    data: {
        labels: ['Domisili', 'Usaha', 'Tidak Mampu', 'Nikah'],
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: [
                {{ $laporanArsip->where('jenis_surat', 'Surat Keterangan Domisili')->count() }},
                {{ $laporanArsip->where('jenis_surat', 'Surat Keterangan Usaha')->count() }},
                {{ $laporanArsip->where('jenis_surat', 'Surat Keterangan Tidak Mampu')->count() }},
                {{ $laporanArsip->where('jenis_surat', 'Surat Pengantar Nikah')->count() }}
            ],
            backgroundColor: '#007bff'
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
@endpush
@endsection