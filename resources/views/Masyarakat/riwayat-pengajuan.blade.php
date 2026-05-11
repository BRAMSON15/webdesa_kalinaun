<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - SIPAKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardmasyarakat.css') }}">
</head>
<body>
    <div class="dashboard-container">
        @include('Masyarakat.partials.header')
        @include('Masyarakat.partials.sidebar')
        
        <div class="dashboard-main">
            <div class="dashboard-content">
                <div class="container-fluid mt-4">
                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-primary">
                                        <i class="fas fa-history"></i> Riwayat Pengajuan Surat
                                    </h4>
                                    <p class="card-text">Daftar semua pengajuan surat yang pernah Anda ajukan beserta statusnya.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-primary shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Total Pengajuan</h6>
                                            <h2 class="mb-0">{{ auth()->user()->pengajuanSurats()->count() }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-file-alt fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Sedang Diproses</h6>
                                            <h2 class="mb-0">{{ auth()->user()->pengajuanSurats()->where('status', 'diproses')->count() }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-success shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Disetujui</h6>
                                            <h2 class="mb-0">{{ auth()->user()->pengajuanSurats()->where('status', 'disetujui')->count() }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-danger shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Ditolak</h6>
                                            <h2 class="mb-0">{{ auth()->user()->pengajuanSurats()->where('status', 'ditolak')->count() }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-times-circle fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('masyarakat.riwayat-pengajuan') }}" class="row g-3">
                                        <div class="col-md-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Semua Status</option>
                                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
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
                                                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="btn btn-secondary">
                                                <i class="fas fa-redo"></i> Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Pengajuan Surat</h5>
                                </div>
                                <div class="card-body">
                                    @if($pengajuans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jenis Surat</th>
                                                        <th>Keperluan</th>
                                                        <th>Status</th>
                                                        <th>Nomor Surat</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pengajuans as $index => $pengajuan)
                                                        <tr>
                                                            <td>{{ $pengajuans->firstItem() + $index }}</td>
                                                            <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                                            <td>{{ $pengajuan->jenisSurat->nama_surat }}</td>
                                                            <td>{{ Str::limit($pengajuan->keperluan, 50) }}</td>
                                                            <td>
                                                                @if($pengajuan->status == 'diproses')
                                                                    <span class="badge bg-warning text-dark">
                                                                        <i class="fas fa-clock"></i> Sedang Diproses
                                                                    </span>
                                                                @elseif($pengajuan->status == 'disetujui')
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check-circle"></i> Disetujui
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-danger">
                                                                        <i class="fas fa-times-circle"></i> Ditolak
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($pengajuan->nomor_surat)
                                                                    <code>{{ $pengajuan->nomor_surat }}</code>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('masyarakat.detail-pengajuan', $pengajuan->id) }}" 
                                                                       class="btn btn-sm btn-info">
                                                                        <i class="fas fa-eye"></i> Detail
                                                                    </a>
                                                                    @if($pengajuan->status == 'disetujui' && $pengajuan->nomor_surat)
                                                                        <a href="{{ route('masyarakat.download-surat', $pengajuan->id) }}" 
                                                                           class="btn btn-sm btn-success" target="_blank">
                                                                            <i class="fas fa-download"></i> Download
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $pengajuans->links() }}
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada pengajuan surat</h5>
                                            <p class="text-muted">Anda belum pernah mengajukan surat apapun</p>
                                            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Buat Pengajuan Pertama
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('Masyarakat.partials.scripts')
</body>
</html>