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
        padding: 1.5rem;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .avatar-sm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        border-radius: 50%;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: #0aa2c0;
        border-color: #0aa2c0;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .dashboard-content {
            padding: 1rem;
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .table {
            font-size: 0.9rem;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
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
                <h1><i class="fas fa-users me-2"></i>Kelola Data Pengguna</h1>
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
                    <h5><i class="fas fa-users"></i> Daftar Pengguna Sistem</h5>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 25%;">Nama</th>
                                        <th style="width: 20%;">Email</th>
                                        <th style="width: 12%;">Role</th>
                                        <th style="width: 12%;">Status</th>
                                        <th style="width: 13%;">Terdaftar</th>
                                        <th style="width: 13%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <i class="fas fa-user-circle fa-lg text-muted"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if($user->no_hp)
                                                        <br><small class="text-muted">{{ $user->no_hp }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <small>{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role == 'kades')
                                                <span class="badge bg-warning text-dark">Kepala Desa</span>
                                            @else
                                                <span class="badge bg-info">Masyarakat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $user->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info" onclick="showUserDetail({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#userDetailModal" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                                </button>
                                                @if($user->role != 'admin')
                                                    <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#editUserModal" title="Edit Pengguna">
                                                        <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <p class="text-muted">Belum ada data pengguna.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white sticky-top">
                <h5 class="modal-title" id="userDetailModalLabel">
                    <i class="fas fa-user-circle me-2"></i> Detail Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userDetailContent" style="max-height: 70vh; overflow-y: auto;">
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark sticky-top">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editUserContent" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        padding: 0.75rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .user-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        color: white;
    }

    .table-borderless td {
        padding: 0.75rem 0;
        border: none;
    }

    .table-borderless tr {
        border-bottom: 1px solid #dee2e6;
    }

    .table-borderless tr:last-child {
        border-bottom: none;
    }

    .text-danger {
        color: #dc3545;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Add CSRF token to meta tag if not already present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}

const users = @json($users);

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert alert at the top of dashboard-content
    const dashboardContent = document.querySelector('.dashboard-content');
    if (dashboardContent) {
        dashboardContent.insertAdjacentHTML('afterbegin', alertHtml);
    }
}

function showUserDetail(userId) {
    const user = users.find(u => u.id === userId);
    if (!user) return;
    
    const content = `
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="user-avatar mb-3">
                    <i class="fas fa-user-circle fa-4x"></i>
                </div>
                <h5 class="mt-3 fw-bold">${user.name}</h5>
                <span class="badge bg-${getRoleBadgeColor(user.role)} fs-6">${getRoleLabel(user.role)}</span>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Nama Lengkap:</strong></td>
                        <td>${user.name}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><a href="mailto:${user.email}">${user.email}</a></td>
                    </tr>
                    <tr>
                        <td><strong>No. HP:</strong></td>
                        <td>${user.no_hp ? '<a href="tel:' + user.no_hp + '">' + user.no_hp + '</a>' : '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>NIK:</strong></td>
                        <td>${user.nik || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>${user.alamat || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat Lahir:</strong></td>
                        <td>${user.tempat_lahir || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Lahir:</strong></td>
                        <td>${user.tanggal_lahir ? formatDate(user.tanggal_lahir) : '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin:</strong></td>
                        <td>${getGenderLabel(user.jenis_kelamin)}</td>
                    </tr>
                    <tr>
                        <td><strong>Pekerjaan:</strong></td>
                        <td>${user.pekerjaan || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td><span class="badge bg-${getRoleBadgeColor(user.role)}">${getRoleLabel(user.role)}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Terdaftar:</strong></td>
                        <td>${formatDate(user.created_at)}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Update:</strong></td>
                        <td>${formatDate(user.updated_at)}</td>
                    </tr>
                </table>
            </div>
        </div>
    `;
    
    document.getElementById('userDetailContent').innerHTML = content;
}

function editUser(userId) {
    const user = users.find(u => u.id === userId);
    if (!user) return;
    
    const content = `
        <form id="editUserForm" onsubmit="updateUser(event, ${userId})">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="${user.name}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="${user.email}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" class="form-control" name="no_hp" value="${user.no_hp || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" value="${user.nik || ''}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="3">${user.alamat || ''}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" value="${user.tempat_lahir || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="${user.tanggal_lahir || ''}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" ${user.jenis_kelamin === 'L' ? 'selected' : ''}>Laki-laki</option>
                        <option value="P" ${user.jenis_kelamin === 'P' ? 'selected' : ''}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" name="pekerjaan" value="${user.pekerjaan || ''}">
                </div>
            </div>
            ${user.role !== 'admin' ? `
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="masyarakat" ${user.role === 'masyarakat' ? 'selected' : ''}>Masyarakat</option>
                    <option value="kades" ${user.role === 'kades' ? 'selected' : ''}>Kepala Desa</option>
                </select>
            </div>
            ` : ''}
            <div class="text-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    `;
    
    document.getElementById('editUserContent').innerHTML = content;
}

function updateUser(event, userId) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData);
    
    // Show loading
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    submitBtn.disabled = true;
    
    // Make AJAX call to update user
    fetch(`/admin/data-pengguna/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert('success', data.message);
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            
            // Reload page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menyimpan data: ' + error.message);
        
        // Restore button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function getRoleBadgeColor(role) {
    switch(role) {
        case 'admin': return 'danger';
        case 'kades': return 'warning';
        default: return 'info';
    }
}

function getRoleLabel(role) {
    switch(role) {
        case 'admin': return 'Admin';
        case 'kades': return 'Kepala Desa';
        default: return 'Masyarakat';
    }
}

function getGenderLabel(gender) {
    switch(gender) {
        case 'L': return 'Laki-laki';
        case 'P': return 'Perempuan';
        default: return '-';
    }
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>
@endsection