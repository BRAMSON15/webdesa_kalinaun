@extends('layouts.sipakal')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
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
