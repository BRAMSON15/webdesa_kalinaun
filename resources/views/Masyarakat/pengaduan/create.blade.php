@extends('layouts.masyarakat')

@section('title', 'Buat Pengaduan - SIPAKAL')

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

    .page-container {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .content-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 15px;
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
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        outline: none;
    }

    .form-text {
        font-size: 0.8rem;
        color: var(--text-gray);
        margin-top: 4px;
    }

    .char-counter {
        text-align: right;
        font-size: 0.75rem;
        color: var(--text-gray);
        margin-top: 4px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
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
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--light-green);
        color: var(--text-dark);
    }

    .btn-secondary:hover {
        background: #a5d6a7;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background: var(--light-green);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .back-btn:hover {
        background: #a5d6a7;
        transform: translateX(-3px);
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

    @media (max-width: 576px) {
        .btn-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-plus-circle"></i> Buat Pengaduan Baru</h4>
        <p>Sampaikan keluhan atau masukan Anda kepada desa</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.pengaduan.index') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Petunjuk Pengaduan:</strong>
                <p style="margin: 5px 0 0 0; font-size: 0.85rem;">
                    Jelaskan keluhan atau masukan Anda secara detail agar kami dapat menindaklanjuti dengan baik. 
                    Pengaduan Anda akan diproses dalam waktu maksimal 7 hari kerja.
                </p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error">
            <div style="flex: 1;">
                <div style="font-weight: 600; margin-bottom: 8px;">
                    <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                </div>
                <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i> Judul Pengaduan
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                       name="judul" placeholder="Masukkan judul pengaduan Anda" 
                       value="{{ old('judul') }}" maxlength="100" required>
                <div class="form-text">Maksimal 100 karakter</div>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag"></i> Kategori Pengaduan
                    <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('kategori') is-invalid @enderror" 
                        name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="layanan" {{ old('kategori') == 'layanan' ? 'selected' : '' }}>Layanan Publik</option>
                    <option value="infrastruktur" {{ old('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="kesehatan" {{ old('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="lingkungan" {{ old('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="keamanan" {{ old('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Deskripsi Pengaduan
                    <span class="text-danger">*</span>
                </label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          name="deskripsi" rows="6" placeholder="Jelaskan pengaduan Anda secara detail..." 
                          maxlength="500" required onkeyup="updateCharCount(this)">{{ old('deskripsi') }}</textarea>
                <div class="form-text">Minimal 10 karakter, maksimal 500 karakter</div>
                <div class="char-counter">
                    <span id="charCount">0</span>/500
                </div>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                </button>
                <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function updateCharCount(element) {
        document.getElementById('charCount').textContent = element.value.length;
    }

    // Initialize char count
    const deskripsi = document.querySelector('textarea[name="deskripsi"]');
    if (deskripsi) {
        updateCharCount(deskripsi);
    }
</script>

@endsection
