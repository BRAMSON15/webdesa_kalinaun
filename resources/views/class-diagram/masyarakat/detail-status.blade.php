<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Status Pengajuan - SIPAKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardmasyarakat.css') }}">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <h3><i class="fas fa-users"></i> SIPAKAL</h3>
                <p class="text-muted">Masyarakat</p>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('class-diagram.masyarakat.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('class-diagram.masyarakat.form-pengajuan') }}">
                        <i class="fas fa-file-alt"></i> Buat Pengajuan Surat
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('class-diagram.masyarakat.riwayat-pengajuan') }}">
                        <i class="fas fa-history"></i> Riwayat Pengajuan
                    </a>
                </li>
                <li>
                    <a href="{{ route('class-diagram.masyarakat.profil') }}">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="ms-3 fw-bold">Detail Status Pengajuan</span>
                    <div class="ms-auto">
                        <span class="navbar-text">
                            <i class="fas fa-user-circle"></i> {{ Auth::guard('masyarakat')->user()->nama }}
                        </span>
                    </div>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detail Status Pengajuan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Jenis Surat:</div>
                                    <div class="col-md-8">{{ $pengajuan->jenis_surat }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tanggal Pengajuan:</div>
                                    <div class="col-md-8">{{ $pengajuan->tgl_pengajuan->format('d F Y, H:i') }} WIB</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Status Saat Ini:</div>
                                    <div class="col-md-8">
                                        @if($statusDetail['status'] === 'proses')
                                            <span class="badge bg-warning text-dark fs-6">
                                                <i class="fas fa-clock"></i> {{ $statusDetail['status_text'] }}
                                            </span>
                                        @elseif($statusDetail['status'] === 'selesai')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-check-circle"></i> {{ $statusDetail['status_text'] }}
                                            </span>
                                        @elseif($statusDetail['status'] === 'ditolak')
                                            <span class="badge bg-danger fs-6">
                                                <i class="fas fa-times-circle"></i> {{ $statusDetail['status_text'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Keterangan:</div>
                                    <div class="col-md-8">{{ $pengajuan->keterangan }}</div>
                                </div>

                                @if($pengajuan->catatan)
                                    <div class="alert alert-info mt-3">
                                        <h6 class="alert-heading"><i class="fas fa-sticky-note"></i> Catatan dari Sekdes:</h6>
                                        <p class="mb-0">{{ $pengajuan->catatan }}</p>
                                    </div>
                                @endif

                                @if($statusDetail['status'] === 'selesai')
                                    <div class="alert alert-success mt-3">
                                        <h6 class="alert-heading"><i class="fas fa-check-circle"></i> Pengajuan Selesai</h6>
                                        <p class="mb-0">
                                            Pengajuan surat Anda telah selesai diproses pada 
                                            {{ $pengajuan->tgl_selesai->format('d F Y, H:i') }} WIB.
                                            Silakan datang ke kantor desa untuk mengambil surat.
                                        </p>
                                    </div>
                                @elseif($statusDetail['status'] === 'ditolak')
                                    <div class="alert alert-danger mt-3">
                                        <h6 class="alert-heading"><i class="fas fa-times-circle"></i> Pengajuan Ditolak</h6>
                                        <p class="mb-0">
                                            Pengajuan surat Anda ditolak pada 
                                            {{ $pengajuan->tgl_selesai->format('d F Y, H:i') }} WIB.
                                            @if($pengajuan->catatan)
                                                Silakan periksa catatan di atas untuk informasi lebih lanjut.
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <div class="alert alert-warning mt-3">
                                        <h6 class="alert-heading"><i class="fas fa-clock"></i> Sedang Diproses</h6>
                                        <p class="mb-0">
                                            Pengajuan surat Anda sedang dalam proses verifikasi. 
                                            Mohon tunggu konfirmasi lebih lanjut.
                                        </p>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('class-diagram.masyarakat.riwayat-pengajuan') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Status -->
                        <div class="card shadow-sm mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-stream"></i> Timeline Proses</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Pengajuan Dibuat</h6>
                                            <p class="text-muted mb-0">{{ $pengajuan->tgl_pengajuan->format('d F Y, H:i') }} WIB</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item {{ in_array($pengajuan->status, ['selesai', 'ditolak']) ? 'completed' : 'active' }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Proses Verifikasi</h6>
                                            <p class="text-muted mb-0">
                                                @if(in_array($pengajuan->status, ['selesai', 'ditolak']))
                                                    Selesai diverifikasi
                                                @else
                                                    Sedang dalam proses verifikasi
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="timeline-item {{ $pengajuan->status === 'selesai' ? 'completed' : ($pengajuan->status === 'ditolak' ? 'rejected' : '') }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>
                                                @if($pengajuan->status === 'selesai')
                                                    Selesai
                                                @elseif($pengajuan->status === 'ditolak')
                                                    Ditolak
                                                @else
                                                    Menunggu Penyelesaian
                                                @endif
                                            </h6>
                                            <p class="text-muted mb-0">
                                                @if($pengajuan->tgl_selesai)
                                                    {{ $pengajuan->tgl_selesai->format('d F Y, H:i') }} WIB
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('class-diagram.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>

    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline-item {
            position: relative;
            padding-left: 40px;
            padding-bottom: 30px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 20px;
            bottom: -10px;
            width: 2px;
            background: #dee2e6;
        }
        .timeline-item:last-child:before {
            display: none;
        }
        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #dee2e6;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }
        .timeline-item.completed .timeline-marker {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }
        .timeline-item.active .timeline-marker {
            background: #ffc107;
            box-shadow: 0 0 0 2px #ffc107;
        }
        .timeline-item.rejected .timeline-marker {
            background: #dc3545;
            box-shadow: 0 0 0 2px #dc3545;
        }
    </style>
</body>
</html>
