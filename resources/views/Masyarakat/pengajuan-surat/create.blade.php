@extends('layouts.masyarakat')

@section('title', 'Form Pengajuan Surat')

@section('content')
<style>
    :root {
        --primary-green: #28a745;
        --primary-dark: #1f7e34;
        --light-green: #c8e6c9;
        --very-light-green: #e8f5e9;
        --text-dark: #2d5016;
        --text-gray: #666;
        --border-light: #e0e0e0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .mobile-page {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 0;
    }

    .page-header-back {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .page-header-back:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateX(-3px);
    }

    .page-header-title {
        flex: 1;
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .page-header p {
        margin: 4px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .page-content {
        padding: 15px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-light);
        margin-bottom: 15px;
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 15px 20px;
        margin: -20px -20px 20px -20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-header h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .form-section-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
        margin: 20px 0 15px 0;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--light-green);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        outline: none;
    }

    .form-control[readonly] {
        background: var(--very-light-green);
        color: var(--text-dark);
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .form-text {
        font-size: 0.8rem;
        color: #999;
        margin-top: 4px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .alert-custom {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .alert-success-custom {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger-custom {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert-info-custom {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    .info-card {
        background: var(--very-light-green);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid var(--primary-green);
    }

    .info-card-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-card-item {
        padding: 8px 0;
        font-size: 0.9rem;
        color: var(--text-gray);
        line-height: 1.5;
    }

    .info-card-item strong {
        color: var(--text-dark);
    }

    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }

    .requirements-list li {
        padding: 6px 0;
        padding-left: 24px;
        position: relative;
        font-size: 0.9rem;
        color: var(--text-gray);
        line-height: 1.4;
    }

    .requirements-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--primary-green);
        font-weight: bold;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        flex: 1;
        padding: 12px 15px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-secondary {
        background: #e0e0e0;
        color: #333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
        background: #d0d0d0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .text-danger {
        color: #dc3545;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        display: block;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.3rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="mobile-page">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('masyarakat.pengajuan-surat') }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>{{ $jenisSurat->nama_surat }}</h1>
            <p>Form Pengajuan Surat</p>
        </div>
    </div>

    <div class="page-content">
        <!-- Form Card -->
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-file-alt"></i>
                <h2>Formulir Pengajuan</h2>
            </div>

            @if ($errors->any())
                <div class="alert-custom alert-danger-custom">
                    <div>
                        <div style="font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                        </div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('masyarakat.pengajuan-surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

                <!-- Keperluan Section -->
                <div class="mb-3">
                    <label for="keperluan" class="form-label">
                        <i class="fas fa-pen-fancy"></i> Keperluan Pengajuan
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                              id="keperluan" name="keperluan" rows="4" required 
                              placeholder="Jelaskan keperluan pengajuan surat ini...">{{ old('keperluan') }}</textarea>
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> Jelaskan tujuan atau keperluan pengajuan surat
                    </div>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Data Tambahan Section -->
                <div class="form-section-title">
                    <i class="fas fa-user-circle"></i> Data Pribadi
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input type="text" class="form-control" id="nama_lengkap" 
                               name="data_formulir[nama_lengkap]" value="{{ auth()->user()->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">
                            <i class="fas fa-id-card"></i> NIK
                        </label>
                        <input type="text" class="form-control" id="nik" 
                               name="data_formulir[nik]" value="{{ auth()->user()->nik ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <textarea class="form-control" id="alamat" name="data_formulir[alamat]" 
                              rows="2" readonly>{{ auth()->user()->alamat }}</textarea>
                </div>

                <!-- Field tambahan berdasarkan jenis surat -->
                @if(str_contains(strtolower($jenisSurat->nama_surat), 'usaha'))
                <div class="form-section-title">
                    <i class="fas fa-briefcase"></i> Data Usaha
                </div>
                <div class="form-row">
                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">
                            <i class="fas fa-store"></i> Nama Usaha
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('data_formulir.nama_usaha') is-invalid @enderror" 
                               id="nama_usaha" name="data_formulir[nama_usaha]" 
                               value="{{ old('data_formulir.nama_usaha') }}" required>
                        @error('data_formulir.nama_usaha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_usaha" class="form-label">
                            <i class="fas fa-tag"></i> Jenis Usaha
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('data_formulir.jenis_usaha') is-invalid @enderror" 
                               id="jenis_usaha" name="data_formulir[jenis_usaha]" 
                               value="{{ old('data_formulir.jenis_usaha') }}" required>
                        @error('data_formulir.jenis_usaha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat_usaha" class="form-label">
                        <i class="fas fa-location-dot"></i> Alamat Usaha
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('data_formulir.alamat_usaha') is-invalid @enderror" 
                              id="alamat_usaha" name="data_formulir[alamat_usaha]" rows="2" required>{{ old('data_formulir.alamat_usaha') }}</textarea>
                    @error('data_formulir.alamat_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                @if(str_contains(strtolower($jenisSurat->nama_surat), 'nikah'))
                <div class="form-section-title">
                    <i class="fas fa-ring"></i> Data Pernikahan
                </div>
                <div class="form-row">
                    <div class="mb-3">
                        <label for="nama_calon_pasangan" class="form-label">
                            <i class="fas fa-heart"></i> Nama Calon Pasangan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('data_formulir.nama_calon_pasangan') is-invalid @enderror" 
                               id="nama_calon_pasangan" name="data_formulir[nama_calon_pasangan]" 
                               value="{{ old('data_formulir.nama_calon_pasangan') }}" required>
                        @error('data_formulir.nama_calon_pasangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_rencana_nikah" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Tanggal Rencana Nikah
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('data_formulir.tanggal_rencana_nikah') is-invalid @enderror" 
                               id="tanggal_rencana_nikah" name="data_formulir[tanggal_rencana_nikah]" 
                               value="{{ old('data_formulir.tanggal_rencana_nikah') }}" required>
                        @error('data_formulir.tanggal_rencana_nikah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                <!-- Dokumen Pendukung Section -->
                <div class="form-section-title">
                    <i class="fas fa-paperclip"></i> Dokumen Pendukung
                </div>
                <div class="mb-3">
                    <label for="dokumen_pendukung" class="form-label">
                        <i class="fas fa-file-upload"></i> Pilih File
                    </label>
                    <input type="file" class="form-control @error('dokumen_pendukung.*') is-invalid @enderror" 
                           id="dokumen_pendukung" name="dokumen_pendukung[]" multiple 
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> Format: PDF, JPG, PNG. Maksimal 2MB per file
                    </div>
                    @error('dokumen_pendukung.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                    <a href="{{ route('masyarakat.pengajuan-surat') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-info-circle"></i> Informasi Pengajuan
            </div>
            <div class="info-card-item">
                <strong>Jenis Surat:</strong> {{ $jenisSurat->nama_surat }}
            </div>
            @if($jenisSurat->deskripsi)
            <div class="info-card-item">
                <strong>Deskripsi:</strong> {{ $jenisSurat->deskripsi }}
            </div>
            @endif
            @if($jenisSurat->persyaratan && is_array($jenisSurat->persyaratan))
            <div class="info-card-item">
                <strong>Persyaratan:</strong>
                <ul class="requirements-list">
                    @foreach($jenisSurat->persyaratan as $syarat)
                    <li>{{ $syarat }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Processing Info -->
        <div class="alert-custom alert-info-custom">
            <i class="fas fa-clock"></i>
            <div>
                <strong>Estimasi Proses:</strong> Pengajuan akan diproses dalam 1-3 hari kerja setelah dokumen lengkap.
            </div>
        </div>
    </div>
</div>
@endsection