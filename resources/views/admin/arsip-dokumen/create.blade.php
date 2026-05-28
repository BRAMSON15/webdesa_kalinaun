@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<style>
    .dashboard-content {
        padding: 2rem;
        background-color: #f8f9fa;
    }

    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0;
        padding: 1.5rem;
        border: none;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .card-header i {
        margin-right: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .text-danger {
        color: #dc3545;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section-title i {
        color: #667eea;
        font-size: 1.2rem;
    }

    .helper-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
        display: block;
    }

    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-wrapper:hover {
        border-color: #667eea;
        background-color: #f0f2ff;
    }

    .file-upload-wrapper.dragover {
        border-color: #667eea;
        background-color: #f0f2ff;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .file-upload-icon {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .file-upload-text {
        color: #495057;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .file-upload-hint {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .file-info {
        margin-top: 1rem;
        padding: 1rem;
        background-color: #e7f3ff;
        border-left: 4px solid #0dcaf0;
        border-radius: 0.5rem;
        display: none;
    }

    .file-info.show {
        display: block;
    }

    .file-info-name {
        font-weight: 600;
        color: #0c5460;
        margin-bottom: 0.25rem;
    }

    .file-info-size {
        font-size: 0.875rem;
        color: #0c5460;
    }

    .row {
        margin-bottom: 1.5rem;
    }

    .row:last-child {
        margin-bottom: 0;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #dee2e6;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(108, 117, 125, 0.3);
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .file-upload-wrapper {
            padding: 1.5rem;
        }

        .file-upload-icon {
            font-size: 2rem;
        }
    }
</style>

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        @include('admin.partials.header')

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1><i class="fas fa-file-archive me-2"></i>Tambah Arsip Dokumen</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus-circle"></i> Form Tambah Arsip Dokumen Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.arsip-dokumen.store') }}" method="POST" enctype="multipart/form-data" id="formArsipDokumen">
                        @csrf
                        
                        <!-- Informasi Dokumen -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Dokumen
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_dokumen') is-invalid @enderror" 
                                           name="nama_dokumen" 
                                           value="{{ old('nama_dokumen') }}" 
                                           required
                                           placeholder="Contoh: Peraturan Desa No. 1 Tahun 2024">
                                    <span class="helper-text">Masukkan nama atau judul dokumen</span>
                                    @error('nama_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nomor Dokumen</label>
                                    <input type="text" 
                                           class="form-control @error('nomor_dokumen') is-invalid @enderror" 
                                           name="nomor_dokumen" 
                                           value="{{ old('nomor_dokumen') }}"
                                           placeholder="Contoh: 001/PERDES/2024">
                                    <span class="helper-text">Nomor referensi dokumen (opsional)</span>
                                    @error('nomor_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" 
                                            name="kategori" 
                                            required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="surat_masuk" {{ old('kategori') == 'surat_masuk' ? 'selected' : '' }}>
                                            <i class="fas fa-envelope-open-text"></i> Surat Masuk
                                        </option>
                                        <option value="surat_keluar" {{ old('kategori') == 'surat_keluar' ? 'selected' : '' }}>
                                            <i class="fas fa-paper-plane"></i> Surat Keluar
                                        </option>
                                        <option value="sk" {{ old('kategori') == 'sk' ? 'selected' : '' }}>
                                            <i class="fas fa-stamp"></i> Surat Keputusan
                                        </option>
                                        <option value="perdes" {{ old('kategori') == 'perdes' ? 'selected' : '' }}>
                                            <i class="fas fa-scroll"></i> Peraturan Desa
                                        </option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>
                                            <i class="fas fa-file"></i> Lainnya
                                        </option>
                                    </select>
                                    <span class="helper-text">Pilih kategori dokumen</span>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_dokumen') is-invalid @enderror" 
                                           name="tanggal_dokumen" 
                                           value="{{ old('tanggal_dokumen') }}" 
                                           required>
                                    <span class="helper-text">Tanggal pembuatan atau penerbitan dokumen</span>
                                    @error('tanggal_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              name="deskripsi" 
                                              rows="3" 
                                              placeholder="Deskripsi singkat tentang isi dokumen...">{{ old('deskripsi') }}</textarea>
                                    <span class="helper-text">Deskripsi singkat untuk memudahkan pencarian (opsional)</span>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload File -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-upload"></i>
                                Upload File
                            </div>

                            <div class="file-upload-wrapper" id="fileUploadWrapper" onclick="document.getElementById('fileInput').click()">
                                <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="file-upload-text">Klik untuk memilih file atau drag & drop di sini</div>
                                <div class="file-upload-hint">Format: PDF, DOC, DOCX | Maksimal 10MB</div>
                                <input type="file" 
                                       id="fileInput"
                                       class="@error('file') is-invalid @enderror" 
                                       name="file" 
                                       accept=".pdf,.doc,.docx" 
                                       required
                                       onchange="handleFileSelect(event)">
                            </div>

                            <div class="file-info" id="fileInfo">
                                <div class="file-info-name" id="fileName"></div>
                                <div class="file-info-size" id="fileSize"></div>
                            </div>

                            @error('file')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Arsip
                            </button>
                            <a href="{{ route('admin.arsip-dokumen') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Handle file selection
function handleFileSelect(event) {
    const file = event.target.files[0];
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    if (file) {
        // Validasi ukuran file (10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 10MB.');
            event.target.value = '';
            fileInfo.classList.remove('show');
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.');
            event.target.value = '';
            fileInfo.classList.remove('show');
            return;
        }
        
        // Tampilkan info file
        fileName.textContent = '📄 ' + file.name;
        fileSize.textContent = 'Ukuran: ' + (file.size / 1024).toFixed(2) + ' KB';
        fileInfo.classList.add('show');
    }
}

// Drag and drop
const fileUploadWrapper = document.getElementById('fileUploadWrapper');
const fileInput = document.getElementById('fileInput');

fileUploadWrapper.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadWrapper.classList.add('dragover');
});

fileUploadWrapper.addEventListener('dragleave', () => {
    fileUploadWrapper.classList.remove('dragover');
});

fileUploadWrapper.addEventListener('drop', (e) => {
    e.preventDefault();
    fileUploadWrapper.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect({ target: { files: files } });
    }
});

// Validasi form sebelum submit
document.getElementById('formArsipDokumen').addEventListener('submit', function(e) {
    const namaDokumen = document.querySelector('input[name="nama_dokumen"]').value.trim();
    const kategori = document.querySelector('select[name="kategori"]').value;
    const tanggalDokumen = document.querySelector('input[name="tanggal_dokumen"]').value;
    const file = document.getElementById('fileInput').files[0];
    
    if (!namaDokumen) {
        e.preventDefault();
        alert('Nama dokumen tidak boleh kosong');
        return false;
    }
    
    if (!kategori) {
        e.preventDefault();
        alert('Kategori harus dipilih');
        return false;
    }
    
    if (!tanggalDokumen) {
        e.preventDefault();
        alert('Tanggal dokumen harus diisi');
        return false;
    }
    
    if (!file) {
        e.preventDefault();
        alert('File dokumen harus dipilih');
        return false;
    }
});
</script>
@endsection