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

    .persyaratan-item {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        align-items: center;
    }

    .persyaratan-item input {
        flex: 1;
    }

    .persyaratan-item .btn {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .persyaratan-item .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
    }

    .form-check {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.3rem;
        cursor: pointer;
        border-radius: 0.25rem;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-label {
        margin-left: 0.5rem;
        cursor: pointer;
        font-weight: 500;
        color: #495057;
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

    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 0.5rem 0.75rem;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        padding: 0.5rem 0.75rem;
    }

    .btn-success:hover {
        background-color: #218838;
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
                <h1><i class="fas fa-file-alt me-2"></i>Edit Jenis Surat</h1>
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
                    <h5><i class="fas fa-edit"></i> Form Edit Jenis Surat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jenis-surat.update', $jenisSurat->id) }}" method="POST" id="formJenisSurat">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Dasar
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Surat <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_surat') is-invalid @enderror" 
                                       name="nama_surat" 
                                       value="{{ old('nama_surat', $jenisSurat->nama_surat) }}" 
                                       required
                                       placeholder="Contoh: Surat Keterangan Domisili">
                                <span class="helper-text">Masukkan nama jenis surat</span>
                                @error('nama_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" 
                                          rows="4" 
                                          placeholder="Jelaskan tujuan dan kegunaan surat ini...">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                                <span class="helper-text">Deskripsi singkat tentang jenis surat ini (opsional)</span>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Persyaratan -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-list-check"></i>
                                Persyaratan
                            </div>

                            <div id="persyaratan-container">
                                @if($jenisSurat->persyaratan && count($jenisSurat->persyaratan) > 0)
                                    @foreach($jenisSurat->persyaratan as $persyaratan)
                                    <div class="persyaratan-item">
                                        <input type="text" 
                                               class="form-control" 
                                               name="persyaratan[]" 
                                               value="{{ $persyaratan }}"
                                               placeholder="Masukkan persyaratan">
                                        <button type="button" class="btn btn-danger" onclick="removePersyaratan(this)" title="Hapus persyaratan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="persyaratan-item">
                                        <input type="text" 
                                               class="form-control" 
                                               name="persyaratan[]" 
                                               placeholder="Contoh: Fotokopi KTP">
                                        <button type="button" class="btn btn-success" onclick="addPersyaratan()" title="Tambah persyaratan">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <span class="helper-text">Tambahkan persyaratan yang diperlukan untuk surat ini. Kosongkan jika tidak ada persyaratan khusus.</span>
                        </div>

                        <!-- Status -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       id="is_active"
                                       {{ $jenisSurat->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Aktifkan jenis surat ini</strong>
                                    <br>
                                    <small class="text-muted">Jenis surat yang aktif akan tersedia untuk pengajuan oleh masyarakat</small>
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.jenis-surat') }}" class="btn btn-secondary">
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
function addPersyaratan() {
    const container = document.getElementById('persyaratan-container');
    const itemCount = container.querySelectorAll('.persyaratan-item').length;
    
    const div = document.createElement('div');
    div.className = 'persyaratan-item';
    div.innerHTML = `
        <input type="text" 
               class="form-control" 
               name="persyaratan[]" 
               placeholder="Masukkan persyaratan lainnya">
        <button type="button" 
                class="btn btn-danger" 
                onclick="removePersyaratan(this)" 
                title="Hapus persyaratan">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
    
    // Focus ke input baru
    div.querySelector('input').focus();
}

function removePersyaratan(button) {
    const container = document.getElementById('persyaratan-container');
    const items = container.querySelectorAll('.persyaratan-item');
    
    // Jangan hapus jika hanya ada 1 item
    if (items.length > 1) {
        button.parentElement.remove();
    } else {
        alert('Minimal harus ada 1 field persyaratan');
    }
}

// Validasi form sebelum submit
document.getElementById('formJenisSurat').addEventListener('submit', function(e) {
    const namaSurat = document.querySelector('input[name="nama_surat"]').value.trim();
    
    if (!namaSurat) {
        e.preventDefault();
        alert('Nama surat tidak boleh kosong');
        return false;
    }
});
</script>
@endsection
