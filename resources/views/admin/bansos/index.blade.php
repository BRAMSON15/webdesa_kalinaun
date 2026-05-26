@extends('layouts.app')

@section('title', 'Kelola Program Bansos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-hand-holding-heart"></i> Kelola Program Bansos</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.bansos.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Program
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

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
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Program</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bansos.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="status" class="mr-2">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="form-group mr-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama program..." value="{{ request('search') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('admin.bansos.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Program Bansos</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Program</th>
                        <th>Jenis</th>
                        <th>Periode</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bansos as $index => $program)
                        <tr>
                            <td>{{ $bansos->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $program->nama_bansos }}</strong>
                            </td>
                            <td>{{ $program->jenis_bansos }}</td>
                            <td>
                                {{ $program->tanggal_mulai->format('d/m/Y') }} - {{ $program->tanggal_selesai->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $program->kuota_terpakai }}/{{ $program->kuota }}</span>
                            </td>
                            <td>
                                @switch($program->status)
                                    @case('aktif')
                                        <span class="badge badge-success">Aktif</span>
                                        @break
                                    @case('nonaktif')
                                        <span class="badge badge-warning">Nonaktif</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge badge-secondary">Selesai</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.bansos.show', $program) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.bansos.edit', $program) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.bansos.manage-penerima', $program) }}" class="btn btn-sm btn-primary" title="Kelola Penerima">
                                    <i class="fas fa-users"></i>
                                </a>
                                <form action="{{ route('admin.bansos.destroy', $program) }}" method="POST" style="display:inline;">
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
                                <i class="fas fa-inbox"></i> Tidak ada program bansos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $bansos->links() }}
        </div>
    </div>
</div>
@endsection
