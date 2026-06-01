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
                <h1>Status Pengajuan & Pengaduan</h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file-alt"></i> Daftar Pengajuan Surat</h5>
                </div>
                <div class="card-body">
                    @if($pengajuans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemohon</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengajuans as $index => $pengajuan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pengajuan->user->name ?? 'N/A' }}</td>
                                        <td>{{ $pengajuan->jenisSurat->nama_surat ?? 'N/A' }}</td>
                                        <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($pengajuan->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($pengajuan->status == 'diproses')
                                                <span class="badge bg-info">Diproses</span>
                                            @elseif($pengajuan->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info" onclick="viewPengajuanDetail({{ $pengajuan->id }})" data-bs-toggle="modal" data-bs-target="#pengajuanDetailModal">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                @if($pengajuan->status == 'disetujui')
                                                    <a href="{{ route('admin.cetak-surat', $pengajuan->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </a>
                                                @endif
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
                            <p class="text-muted">Belum ada pengajuan surat.</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Pengajuan Detail Modal -->
            <div class="modal fade" id="pengajuanDetailModal" tabindex="-1" aria-labelledby="pengajuanDetailModalLabel" aria-hidden="true" style="z-index: 9999;">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" style="margin-top: 60px;">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="pengajuanDetailModalLabel">
                                <i class="fas fa-file-alt"></i> Detail Pengajuan Surat
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="pengajuanDetailContent" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
const pengajuans = @json($pengajuans);
function viewPengajuanDetail(id) {
    const pengajuan = pengajuans.find(p => p.id === id);
    if (!pengajuan) {
        console.error('Pengajuan not found:', id);
        return;
    }
    console.log('Pengajuan data:', pengajuan);
    let content = `
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>📋 Informasi Pengajuan</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="150"><strong>Nama Pemohon:</strong></td>
                                <td><strong>${pengajuan.user ? pengajuan.user.name : 'N/A'}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>${pengajuan.user ? pengajuan.user.email : 'N/A'}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP:</strong></td>
                                <td>${pengajuan.user && pengajuan.user.no_hp ? pengajuan.user.no_hp : '-'}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK:</strong></td>
                                <td>${pengajuan.user && pengajuan.user.nik ? pengajuan.user.nik : '-'}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>${pengajuan.user && pengajuan.user.alamat ? pengajuan.user.alamat : '-'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>📄 Detail Pengajuan</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="150"><strong>Jenis Surat:</strong></td>
                                <td>${pengajuan.jenis_surat ? pengajuan.jenis_surat.nama_surat : 'N/A'}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Pengajuan:</strong></td>
                                <td>${formatDate(pengajuan.created_at)}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><span class="badge bg-${getStatusBadgeColor(pengajuan.status)}">${getStatusLabel(pengajuan.status)}</span></td>
                            </tr>
                            ${pengajuan.nomor_surat ? `
                            <tr>
                                <td><strong>Nomor Surat:</strong></td>
                                <td><strong>${pengajuan.nomor_surat}</strong></td>
                            </tr>
                            ` : ''}
                        </table>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>📝 Keperluan</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">${pengajuan.keperluan || '<em class="text-muted">Tidak ada keterangan keperluan</em>'}</p>
                    </div>
                </div>
    `;
    if (pengajuan.data_formulir) {
        content += `
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>📊 Data Formulir</strong>
                    </div>
                    <div class="card-body">
                        <pre>${JSON.stringify(pengajuan.data_formulir, null, 2)}</pre>
                    </div>
                </div>
        `;
    }
    if (pengajuan.dokumen_pendukung && pengajuan.dokumen_pendukung.length > 0) {
        content += `
                <div class="card">
                    <div class="card-header">
                        <strong>📎 Dokumen Pendukung</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
        `;
        pengajuan.dokumen_pendukung.forEach((doc, index) => {
            content += `
                            <div class="col-md-6 mb-2">
                                <a href="/storage/${doc}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-file-download"></i> Dokumen ${index + 1}
                                </a>
                            </div>
            `;
        });
        content += `
                        </div>
                    </div>
                </div>
        `;
    }
    content += `
            </div>
        </div>
    `;
    const contentElement = document.getElementById('pengajuanDetailContent');
    if (contentElement) {
        contentElement.innerHTML = content;
        console.log('Content updated successfully');
    } else {
        console.error('Content element not found');
    }
}
function getStatusBadgeColor(status) {
    switch(status) {
        case 'pending': return 'warning';
        case 'diproses': return 'info';
        case 'disetujui': return 'success';
        case 'ditolak': return 'danger';
        default: return 'secondary';
    }
}
function getStatusLabel(status) {
    switch(status) {
        case 'pending': return 'Pending';
        case 'diproses': return 'Diproses';
        case 'disetujui': return 'Disetujui';
        case 'ditolak': return 'Ditolak';
        default: return status;
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
</script>
@endsection