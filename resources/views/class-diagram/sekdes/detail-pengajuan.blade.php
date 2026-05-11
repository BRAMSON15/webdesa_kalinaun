@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-file-alt"></i> Detail Pengajuan Surat</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Pengajuan -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Pengajuan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>ID Pengajuan:</strong><br>
                            <code>#{{ str_pad($pengajuan->id_surat, 6, '0', STR_PAD_LEFT) }}</code>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Pengajuan:</strong><br>
                            {{ $pengajuan->tgl_pengajuan->format('d F Y') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Jenis Surat:</strong><br>
                            <span class="badge bg-info">{{ $pengajuan->jenis_surat }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            {!! $pengajuan->status_badge !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Keterangan/Keperluan:</strong>
                        <div class="alert alert-light mt-2">
                            {{ $pengajuan->keterangan }}
                        </div>
                    </div>

                    @if($pengajuan->catatan_validasi)
                    <div class="mb-3">
                        <strong>Catatan Validasi:</strong>
                        <div class="alert alert-warning mt-2">
                            <i class="fas fa-sticky-note"></i> {{ $pengajuan->catatan_validasi }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Data Pemohon -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Data Pemohon</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Nama Lengkap:</th>
                                    <td>{{ $pengajuan->masyarakat->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIK:</th>
                                    <td><code>{{ $pengajuan->masyarakat->nik }}</code></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $pengajuan->masyarakat->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">No. HP:</th>
                                    <td>{{ $pengajuan->masyarakat->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Terdaftar:</th>
                                    <td>{{ $pengajuan->masyarakat->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Pengajuan:</th>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $pengajuan->masyarakat->pengajuanSurat()->count() }} pengajuan
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Timeline Pengajuan</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pengajuan Dibuat</h6>
                                <p class="text-muted mb-0">
                                    <small>
                                        <i class="fas fa-calendar"></i> {{ $pengajuan->created_at->format('d F Y, H:i') }}
                                    </small>
                                </p>
                            </div>
                        </div>
                        @if($pengajuan->status != 'proses')
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $pengajuan->status == 'selesai' ? 'bg-success' : 'bg-danger' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $pengajuan->status == 'selesai' ? 'Disetujui' : 'Ditolak' }}</h6>
                                <p class="text-muted mb-0">
                                    <small>
                                        <i class="fas fa-calendar"></i> {{ $pengajuan->updated_at->format('d F Y, H:i') }}
                                    </small>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Form Validasi -->
            @if($pengajuan->status == 'proses')
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-check-double"></i> Form Validasi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('class-diagram.sekdes.validasi-akhir', $pengajuan->id_surat) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="status" class="form-label">Keputusan <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="selesai" style="color: green;">✓ Setujui Pengajuan</option>
                                <option value="ditolak" style="color: red;">✗ Tolak Pengajuan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="4" 
                                      placeholder="Berikan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                            <div class="form-text">Catatan akan dikirim ke pemohon via email</div>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Proses Validasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-{{ $pengajuan->status == 'selesai' ? 'success' : 'danger' }}">
                <h5>
                    <i class="fas fa-{{ $pengajuan->status == 'selesai' ? 'check-circle' : 'times-circle' }}"></i>
                    Pengajuan {{ $pengajuan->status == 'selesai' ? 'Disetujui' : 'Ditolak' }}
                </h5>
                <p class="mb-0">Pengajuan ini sudah diproses pada {{ $pengajuan->updated_at->format('d F Y, H:i') }}</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('class-diagram.sekdes.daftar-pengajuan') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('class-diagram.sekdes.dashboard') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home"></i> Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-lightbulb"></i> Panduan Validasi</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Periksa kelengkapan data pemohon</li>
                        <li>Pastikan keterangan jelas dan valid</li>
                        <li>Berikan catatan jika ada yang perlu diperbaiki</li>
                        <li>Notifikasi akan dikirim otomatis ke pemohon</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: -21px;
    top: 20px;
    height: calc(100% - 10px);
    width: 2px;
    background: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endsection