@extends('layouts.app')

@section('title', 'Kelola Pengaduan Masyarakat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-comments"></i> Kelola Pengaduan Masyarakat</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Pengaduan</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="status" class="mr-2">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group mr-3">
                    <label for="kategori" class="mr-2">Kategori:</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <option value="layanan" {{ request('kategori') == 'layanan' ? 'selected' : '' }}>Layanan</option>
                        <option value="infrastruktur" {{ request('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                        <option value="kesehatan" {{ request('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="pendidikan" {{ request('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group mr-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pengaduan</h5>
                    <h2 class="text-primary">{{ $pengaduans->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Baru</h5>
                    <h2 class="text-warning">{{ \App\Models\Pengaduan::where('status', 'baru')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Diproses</h5>
                    <h2 class="text-info">{{ \App\Models\Pengaduan::where('status', 'diproses')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="text-success">{{ \App\Models\Pengaduan::where('status', 'selesai')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Pengaduan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $index => $pengaduan)
                        <tr>
                            <td>{{ $pengaduans->firstItem() + $index }}</td>
                            <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ Str::limit($pengaduan->judul, 30) }}</strong>
                            </td>
                            <td>{{ $pengaduan->user->name }}</td>
                            <td>
                                <span class="badge badge-info">{{ ucfirst($pengaduan->kategori) }}</span>
                            </td>
                            <td>
                                @switch($pengaduan->status)
                                    @case('baru')
                                        <span class="badge badge-warning">Baru</span>
                                        @break
                                    @case('diproses')
                                        <span class="badge badge-info">Diproses</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge badge-success">Selesai</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tidak ada pengaduan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
@endsection
