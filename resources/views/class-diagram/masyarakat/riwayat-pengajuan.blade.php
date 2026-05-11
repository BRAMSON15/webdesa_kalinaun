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
                    <span class="ms-3 fw-bold">Riwayat Pengajuan Surat</span>
                    <div class="ms-auto">
                        <span class="navbar-text">
                            <i class="fas fa-user-circle"></i> {{ Auth::guard('masyarakat')->user()->nama }}
                        </span>
                    </div>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Pengajuan Surat</h5>
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
                                            <th>Status</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengajuans as $index => $pengajuan)
                                            <tr>
                                                <td>{{ $pengajuans->firstItem() + $index }}</td>
                                                <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</td>
                                                <td>{{ $pengajuan->jenis_surat }}</td>
                                                <td>
                                                    @if($pengajuan->status === 'proses')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock"></i> Diproses
                                                        </span>
                                                    @elseif($pengajuan->status === 'selesai')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                    @elseif($pengajuan->status === 'ditolak')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $pengajuan->tgl_selesai ? $pengajuan->tgl_selesai->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('class-diagram.masyarakat.cek-status', $pengajuan->id_pengajuan) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $pengajuans->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada riwayat pengajuan surat.</p>
                                <a href="{{ route('class-diagram.masyarakat.form-pengajuan') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Pengajuan Baru
                                </a>
                            </div>
                        @endif
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
</body>
</html>
