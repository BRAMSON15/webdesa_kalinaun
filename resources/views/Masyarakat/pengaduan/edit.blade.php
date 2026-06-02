@extends('layouts.masyarakat')

@section('title', 'Edit Pengaduan')

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

    .mb-3 {
        margin-bottom: 15px;
    }

    .form-text {
        font-size: 0.8rem;
        color: #999;
        margin-top: 4px;
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

    .alert-warning-custom {
        background: #fff3cd;
        color: #856404;
        border-left: 4px solid #ffc107;
    }

    .alert-warning-custom ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
        font-size: 0.85rem;
    }

    .alert-danger-custom {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert-danger-custom ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
        font-size: 0.85rem;
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

    .btn-danger {
        background: #dc3545;
        color: white;
        width: 100%;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
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
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .info-card-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(40, 167, 69, 0.1);
        font-size: 0.9rem;
    }

    .info-card-item:last-child {
        border-bottom: none;
    }

    .info-card-label {
        font-weight: 600;
        color: var(--text-dark);
    }

    .info-card-value {
        color: var(--text-gray);
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
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
        <a href="{{ route('masyarakat.pengaduan.show', $pengaduan) }}" class="page-header-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-title">
            <h1>Edit Pengaduan</h1>
            <p>Ubah data pengaduan Anda</p>
        </div>
    </div>

    <div class="page-content">
        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert-custom alert-danger-custom">
                <div>
                    <div style="font-weight: 600; margin-bottom: 8px;">
                        <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-edit"></i>
                <h2>Form Edit Pengaduan</h2>
            </div>

            <form action="{{ route('masyarakat.pengaduan.update', $pengaduan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">
                        <i class="fas fa-heading"></i> Judul Pengaduan
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul pengaduan" value="{{ old('judul', $pengaduan->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">
                        <i class="fas fa-tag"></i> Kategori Pengaduan
                        <span class="text-danger">*</span>
                    </label>
                    <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="layanan" {{ old('kategori', $pengaduan->kategori) == 'layanan' ? 'selected' : '' }}>Layanan Publik</option>
                        <option value="infrastruktur" {{ old('kategori', $pengaduan->kategori) == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                        <option value="kesehatan" {{ old('kategori', $pengaduan->kategori) == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="pendidikan" {{ old('kategori', $pengaduan->kategori) == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="lainnya" {{ old('kategori', $pengaduan->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        <i class="fas fa-pen-fancy"></i> Deskripsi Pengaduan
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> Minimal 10 karakter
                    </div>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Warning Alert -->
                <div class="alert-custom alert-warning-custom">
                    <div>
                        <div style="font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-exclamation-triangle"></i> Perhatian:
                        </div>
                        <ul>
                            <li>Anda hanya dapat mengedit pengaduan dengan status "Baru"</li>
                            <li>Setelah status berubah, pengaduan tidak dapat diubah lagi</li>
                            <li>Perubahan akan dicatat dalam sistem</li>
                        </ul>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('masyarakat.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-info-circle"></i> Informasi Pengaduan
            </div>
            <div class="info-card-item">
                <span class="info-card-label">ID Pengaduan:</span>
                <span class="info-card-value">#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-card-item">
                <span class="info-card-label">Status:</span>
                <span>
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
                </span>
            </div>
            <div class="info-card-item">
                <span class="info-card-label">Dibuat:</span>
                <span class="info-card-value">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-card-item">
                <span class="info-card-label">Diubah:</span>
                <span class="info-card-value">{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- Delete Action -->
        <form action="{{ route('masyarakat.pengaduan.destroy', $pengaduan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus Pengaduan
            </button>
        </form>
    </div>
</div>
@endsection
