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
                <h1>Kelola Informasi Desa</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-info-circle"></i> Daftar Informasi Desa</h5>
                    <a href="{{ route('admin.informasi-desa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Informasi
                    </a>
                </div>
                <div class="card-body">
                    @if($informasis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($informasis as $index => $informasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $informasi->judul }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($informasi->kategori) }}</span>
                                        </td>
                                        <td>
                                            @if($informasi->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $informasi->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-info" onclick="viewInformasi({{ $informasi->id }})" data-bs-toggle="modal" data-bs-target="#informasiDetailModal">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="#" class="btn btn-sm btn-warning" onclick="editInformasi({{ $informasi->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger" onclick="deleteInformasi({{ $informasi->id }})">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada informasi desa.</p>
                            <a href="{{ route('admin.informasi-desa.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Informasi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Informasi Detail Modal -->
<div class="modal fade" id="informasiDetailModal" tabindex="-1" aria-labelledby="informasiDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white sticky-top">
                <h5 class="modal-title" id="informasiDetailModalLabel">
                    <i class="fas fa-info-circle"></i> Detail Informasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="informasiDetailContent" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light sticky-bottom">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const informasis = @json($informasis);

function viewInformasi(id) {
    const informasi = informasis.find(i => i.id === id);
    if (!informasi) return;
    
    const content = `
        <div class="row">
            <div class="col-12">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Judul:</strong></td>
                        <td>${informasi.judul}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori:</strong></td>
                        <td><span class="badge bg-info">${informasi.kategori.charAt(0).toUpperCase() + informasi.kategori.slice(1)}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="badge bg-${informasi.status === 'published' ? 'success' : 'warning'}">${informasi.status === 'published' ? 'Published' : 'Draft'}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>${formatDate(informasi.created_at)}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate:</strong></td>
                        <td>${formatDate(informasi.updated_at)}</td>
                    </tr>
                </table>
                <hr>
                <h6><strong>Konten:</strong></h6>
                <div class="border rounded p-3 bg-light">
                    ${informasi.konten.replace(/\n/g, '<br>')}
                </div>
                ${informasi.gambar ? `
                <hr>
                <h6><strong>Gambar:</strong></h6>
                <img src="/storage/${informasi.gambar}" class="img-fluid rounded" alt="Gambar Informasi">
                ` : ''}
            </div>
        </div>
    `;
    
    document.getElementById('informasiDetailContent').innerHTML = content;
}

function editInformasi(id) {
    // Redirect to edit page (you can create this route)
    window.location.href = `/admin/informasi-desa/${id}/edit`;
}

function deleteInformasi(id) {
    if (confirm('Yakin ingin menghapus informasi ini?')) {
        // Make AJAX call to delete
        fetch(`/admin/informasi-desa/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Informasi berhasil dihapus!');
                window.location.reload();
            } else {
                alert('Gagal menghapus informasi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus informasi');
        });
    }
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Add CSRF token if not present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}
</script>
@endsection