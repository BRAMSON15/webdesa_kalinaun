@extends('layouts.masyarakat')

@section('title', 'Dashboard Masyarakat - SIPAKAL')

@section('content')
                    <!-- Welcome Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-primary">
                                        <i class="fas fa-home"></i> Dashboard Masyarakat
                                    </h4>
                                    <p class="card-text">Selamat datang, <strong>{{ auth()->user()->name ?? 'Masyarakat' }}</strong>! Kelola pengajuan surat dan informasi desa Anda di sini.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-primary shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Total Pengajuan</h6>
                                            <h2 class="mb-0">{{ $stats['total_pengajuan'] ?? 0 }}</h2>
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
                                            <h2 class="mb-0">{{ $stats['pengajuan_diproses'] ?? 0 }}</h2>
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
                                            <h2 class="mb-0">{{ $stats['pengajuan_disetujui'] ?? 0 }}</h2>
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
                                            <h2 class="mb-0">{{ $stats['pengajuan_ditolak'] ?? 0 }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-times-circle fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaduan & Bansos Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-info shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Total Pengaduan</h6>
                                            <h2 class="mb-0">{{ $stats['total_pengaduan'] ?? 0 }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-comments fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-secondary shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Pengaduan Diproses</h6>
                                            <h2 class="mb-0">{{ $stats['pengaduan_diproses'] ?? 0 }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-hourglass-half fa-3x opacity-50"></i>
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
                                            <h6 class="card-title">Bansos Aktif</h6>
                                            <h2 class="mb-0">{{ $stats['bansos_aktif'] ?? 0 }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-hand-holding-heart fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-purple shadow-sm" style="background-color: #9b59b6 !important;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Bansos Terdaftar</h6>
                                            <h2 class="mb-0">{{ $stats['bansos_terdaftar'] ?? 0 }}</h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-list fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Aksi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('masyarakat.pengajuan-surat') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-file-plus"></i> Buat Pengajuan Surat Baru
                                        </a>
                                        <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="btn btn-info">
                                            <i class="fas fa-history"></i> Lihat Riwayat Pengajuan
                                        </a>
                                        <a href="{{ route('masyarakat.informasi-desa') }}" class="btn btn-warning">
                                            <i class="fas fa-info-circle"></i> Informasi Desa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-bell"></i> Pengajuan Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($pengajuanTerbaru) && $pengajuanTerbaru->count() > 0)
                                        @foreach($pengajuanTerbaru as $pengajuan)
                                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                                <div>
                                                    <small class="text-muted">{{ $pengajuan->created_at->format('d/m/Y') }}</small>
                                                    <div>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</div>
                                                </div>
                                                <div>
                                                    @if($pengajuan->status === 'diproses')
                                                        <span class="badge bg-warning">Diproses</span>
                                                    @elseif($pengajuan->status === 'disetujui')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($pengajuan->status === 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="text-center mt-3">
                                            <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="btn btn-sm btn-outline-primary">
                                                Lihat Semua <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                            <p class="text-muted">Belum ada pengajuan</p>
                                            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="btn btn-primary btn-sm">
                                                Buat Pengajuan Pertama
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pengajuan Cepat -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Form Pengajuan Cepat</h5>
                                </div>
                                <div class="card-body">

                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('masyarakat.pengajuan-surat.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="jenis_surat_id" class="form-label">Pilih Jenis Surat <span class="text-danger">*</span></label>
                                                <select name="jenis_surat_id" id="jenis_surat_id" class="form-select @error('jenis_surat_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Jenis Surat --</option>
                                                    @if(isset($jenisSurat))
                                                        @foreach($jenisSurat as $jenis)
                                                            <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                                                {{ $jenis->nama_surat }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('jenis_surat_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="dokumen" class="form-label">Dokumen Persyaratan</label>
                                                <input type="file" class="form-control @error('dokumen_pendukung') is-invalid @enderror" 
                                                       id="dokumen_pendukung" name="dokumen_pendukung[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                                                <div class="form-text">Format: JPG, PNG, PDF. Maksimal 2MB</div>
                                                @error('dokumen_pendukung')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="keperluan" class="form-label">Tujuan Pengajuan <span class="text-danger">*</span></label>
                                            <textarea name="keperluan" id="keperluan" class="form-control @error('keperluan') is-invalid @enderror" 
                                                      rows="3" placeholder="Jelaskan tujuan pengajuan surat ini..." required>{{ old('keperluan') }}</textarea>
                                            @error('keperluan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection