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
                <h1><i class="fas fa-pen-fancy me-2"></i>Tambah Tanda Tangan Elektronik</h1>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
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
                    <h5><i class="fas fa-pen-fancy"></i> Form Tambah Tanda Tangan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tanda-tangan.store') }}" method="POST" id="signatureForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Penanda Tangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_penanda_tangan') is-invalid @enderror" name="nama_penanda_tangan" value="{{ old('nama_penanda_tangan') }}" required>
                                @error('nama_penanda_tangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe Tanda Tangan <span class="text-danger">*</span></label>
                                <select class="form-select @error('signature_type') is-invalid @enderror" name="signature_type" id="signatureType" required onchange="toggleSignatureInput()">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="digital" {{ old('signature_type') === 'digital' ? 'selected' : '' }}>Digital (Gambar Tangan)</option>
                                    <option value="scanned" {{ old('signature_type') === 'scanned' ? 'selected' : '' }}>Scan (Upload File)</option>
                                </select>
                                @error('signature_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Digital Signature Input -->
                        <div id="digitalSignatureInput" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Gambar Tanda Tangan <span class="text-danger">*</span></label>
                                <p class="text-muted small">Silakan gambar tanda tangan Anda di area di bawah ini</p>
                                <canvas id="signatureCanvas" class="signature-canvas" width="400" height="150"></canvas>
                                <div class="btn-group-form">
                                    <button type="button" class="btn btn-secondary" onclick="clearSignature()">
                                        <i class="fas fa-eraser me-2"></i>Hapus
                                    </button>
                                    <button type="button" class="btn btn-info" onclick="downloadSignature()">
                                        <i class="fas fa-download me-2"></i>Download
                                    </button>
                                </div>
                                <input type="hidden" id="signatureImage" name="signature_image" value="{{ old('signature_image') }}">
                                <div id="signaturePreview"></div>
                            </div>
                        </div>
                        <!-- Scanned Signature Input -->
                        <div id="scannedSignatureInput" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Upload File Tanda Tangan <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('signature_image') is-invalid @enderror" id="signatureFile" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                                <div id="scannedPreview"></div>
                                @error('signature_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berlaku Dari</label>
                                <input type="date" class="form-control @error('berlaku_dari') is-invalid @enderror" name="berlaku_dari" value="{{ old('berlaku_dari') }}">
                                @error('berlaku_dari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berlaku Sampai</label>
                                <input type="date" class="form-control @error('berlaku_sampai') is-invalid @enderror" name="berlaku_sampai" value="{{ old('berlaku_sampai') }}">
                                @error('berlaku_sampai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Tanda Tangan
                            </button>
                            <a href="{{ route('admin.tanda-tangan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.js"></script>
<script>
let signaturePad;
let canvas;
document.addEventListener('DOMContentLoaded', function() {
    canvas = document.getElementById('signatureCanvas');
    signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
    });
    // Handle scanned signature file upload
    document.getElementById('signatureFile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('scannedPreview').innerHTML = `
                    <img src="${event.target.result}" class="signature-preview mt-3">
                `;
                document.getElementById('signatureImage').value = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    // Set initial visibility
    toggleSignatureInput();
});
function toggleSignatureInput() {
    const type = document.getElementById('signatureType').value;
    document.getElementById('digitalSignatureInput').style.display = type === 'digital' ? 'block' : 'none';
    document.getElementById('scannedSignatureInput').style.display = type === 'scanned' ? 'block' : 'none';
    if (type === 'digital') {
        setTimeout(() => canvas.width = canvas.offsetWidth, 100);
    }
}
function clearSignature() {
    signaturePad.clear();
    document.getElementById('signaturePreview').innerHTML = '';
}
function downloadSignature() {
    if (signaturePad.isEmpty()) {
        alert('Silakan gambar tanda tangan terlebih dahulu');
        return;
    }
    const link = document.createElement('a');
    link.href = signaturePad.toDataURL();
    link.download = 'tanda-tangan.png';
    link.click();
}
document.getElementById('signatureForm').addEventListener('submit', function(e) {
    const type = document.getElementById('signatureType').value;
    if (type === 'digital') {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Silakan gambar tanda tangan terlebih dahulu');
            return;
        }
        document.getElementById('signatureImage').value = signaturePad.toDataURL();
    } else if (type === 'scanned') {
        if (!document.getElementById('signatureImage').value) {
            e.preventDefault();
            alert('Silakan upload file tanda tangan terlebih dahulu');
            return;
        }
    }
});
</script>
@endsection
