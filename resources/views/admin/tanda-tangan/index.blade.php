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
                <h1><i class="fas fa-pen-fancy me-2"></i>Kelola Tanda Tangan Elektronik</h1>
                <a href="{{ route('admin.tanda-tangan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Tanda Tangan
                </a>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-pen-fancy"></i> Daftar Tanda Tangan Elektronik</h5>
                </div>
                <div class="card-body">
                    @if($tandaTangans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 20%;">Nama</th>
                                        <th style="width: 15%;">Jabatan</th>
                                        <th style="width: 10%;">NIP</th>
                                        <th style="width: 12%;">Tipe</th>
                                        <th style="width: 12%;">Status</th>
                                        <th style="width: 15%;">Berlaku</th>
                                        <th style="width: 11%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tandaTangans as $index => $tandaTangan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $tandaTangan->nama_penanda_tangan }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ $tandaTangan->jabatan }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $tandaTangan->nip ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($tandaTangan->signature_type === 'digital')
                                                <span class="badge bg-info">Digital</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Scan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tandaTangan->is_active && $tandaTangan->isValid())
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times-circle"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tandaTangan->berlaku_dari && $tandaTangan->berlaku_sampai)
                                                <small>
                                                    {{ $tandaTangan->berlaku_dari->format('d/m/Y') }} - 
                                                    {{ $tandaTangan->berlaku_sampai->format('d/m/Y') }}
                                                </small>
                                            @else
                                                <small class="text-muted">Tidak terbatas</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" style="gap: 0.25rem;">
                                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#previewModal" onclick="previewSignature('{{ $tandaTangan->nama_penanda_tangan }}', '{{ $tandaTangan->signature_image }}')" title="Lihat Preview">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('admin.tanda-tangan.edit', $tandaTangan->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-{{ $tandaTangan->is_active ? 'danger' : 'success' }}" type="button" onclick="toggleActive({{ $tandaTangan->id }})" title="{{ $tandaTangan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="fas fa-{{ $tandaTangan->is_active ? 'ban' : 'check' }}"></i>
                                                </button>
                                                <form action="{{ route('admin.tanda-tangan.destroy', $tandaTangan->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus tanda tangan ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-pen-fancy"></i>
                            <p class="text-muted">Belum ada tanda tangan elektronik.</p>
                            <a href="{{ route('admin.tanda-tangan.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Tambah Tanda Tangan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Modal Preview Tanda Tangan -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="fas fa-pen-fancy me-2"></i>Preview Tanda Tangan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="signatureName" class="mb-3"><strong></strong></p>
                <img id="signatureImage" src="" alt="Tanda Tangan" class="signature-preview">
            </div>
        </div>
    </div>
</div>
<script>
function previewSignature(name, imageData) {
    document.getElementById('signatureName').textContent = name;
    document.getElementById('signatureImage').src = imageData;
}
function toggleActive(tandaTanganId) {
    if (!confirm('Apakah Anda yakin ingin mengubah status tanda tangan ini?')) {
        return;
    }
    fetch(`/admin/tanda-tangan/${tandaTanganId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
    });
}
</script>
@endsection
