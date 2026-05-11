@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-check-circle"></i> Validasi Pengajuan Surat</h2>
            <p class="text-muted">Daftar pengajuan surat yang menunggu validasi</p>
            <hr>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="row g-3">
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
                            <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                            <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari">
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                            <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Daftar Pengajuan Menunggu Validasi
                        <span class="badge bg-danger float-end">{{ $pengajuans->total() }} Pengajuan</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($pengajuans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Pemohon</th>
                                    <th width="12%">NIK</th>
                                    <th width="10%">No. HP</th>
                                    <th width="15%">Jenis Surat</th>
                                    <th width="20%">Keterangan</th>
                                    <th width="8%">Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuans as $index => $pengajuan)
                                <tr>
                                    <td>{{ $pengajuans->firstItem() + $index }}</td>
                                    <td>
                                        <small>
                                            <i class="fas fa-calendar"></i> {{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}<br>
                                            <i class="fas fa-clock"></i> {{ $pengajuan->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $pengajuan->masyarakat->nama }}</strong><br>
                                        <small class="text-muted">{{ $pengajuan->masyarakat->email }}</small>
                                    </td>
                                    <td><code>{{ $pengajuan->masyarakat->nik }}</code></td>
                                    <td>{{ $pengajuan->masyarakat->no_hp }}</td>
                                    <td><span class="badge bg-info">{{ $pengajuan->jenis_surat }}</span></td>
                                    <td>
                                        <small>{{ Str::limit($pengajuan->keterangan, 60) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Proses
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('class-diagram.sekdes.detail-pengajuan', $pengajuan->id_surat) }}" 
                                           class="btn btn-sm btn-primary" title="Lihat Detail & Validasi">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Menampilkan {{ $pengajuans->firstItem() }} - {{ $pengajuans->lastItem() }} dari {{ $pengajuans->total() }} pengajuan
                        </div>
                        <div>
                            {{ $pengajuans->links() }}
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Pengajuan Menunggu Validasi</h5>
                        <p class="text-muted">Semua pengajuan sudah diproses</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary">{{ \App\Models\TblPengajuanSurat::where('status', 'proses')->count() }}</h4>
                            <p class="mb-0 text-muted">Menunggu Validasi</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">{{ \App\Models\TblPengajuanSurat::where('status', 'selesai')->whereDate('created_at', today())->count() }}</h4>
                            <p class="mb-0 text-muted">Disetujui Hari Ini</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-danger">{{ \App\Models\TblPengajuanSurat::where('status', 'ditolak')->whereDate('created_at', today())->count() }}</h4>
                            <p class="mb-0 text-muted">Ditolak Hari Ini</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info">{{ \App\Models\TblPengajuanSurat::whereDate('created_at', today())->count() }}</h4>
                            <p class="mb-0 text-muted">Pengajuan Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection