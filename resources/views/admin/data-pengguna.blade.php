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
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5><i class="fas fa-users"></i> Daftar Pengguna Sistem</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari nama, email, atau NIK...">
                            </div>
                        </div>
                    </div>
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
                                        <th style="width: 10%;">Aksi</th>
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
                                            <div class="btn-group" style="gap: 0.25rem;">
                                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#userDetailModal" onclick="showUserDetail({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->no_hp ?? '' }}', '{{ $user->nik ?? '' }}', '{{ addslashes($user->alamat ?? '') }}', '{{ $user->tanggal_lahir ?? '' }}', '{{ $user->jenis_kelamin ?? '' }}', '{{ $user->role }}', '{{ $user->created_at }}', '{{ $user->updated_at }}')" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($user->role != 'admin')
                                                    <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->no_hp ?? '' }}', '{{ $user->nik ?? '' }}', '{{ addslashes($user->alamat ?? '') }}', '{{ $user->tanggal_lahir ?? '' }}', '{{ $user->jenis_kelamin ?? '' }}', '{{ $user->role }}')" title="Edit Pengguna">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                    <button class="btn btn-sm btn-secondary" type="button" onclick="resetPassword({{ $user->id }}, '{{ addslashes($user->name) }}')" title="Reset Password">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" type="button" onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')" title="Hapus Pengguna">
                                                        <i class="fas fa-trash"></i>
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
<script>
// Add CSRF token to meta tag if not already present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('table tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    const dashboardContent = document.querySelector('.dashboard-content');
    if (dashboardContent) {
        dashboardContent.insertAdjacentHTML('afterbegin', alertHtml);
    }
}
function showUserDetail(userId, name, email, noHp, nik, alamat, tanggalLahir, jenisKelamin, role, createdAt, updatedAt) {
    const content = `
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="user-avatar mb-3">
                    <i class="fas fa-user-circle fa-4x"></i>
                </div>
                <h5 class="mt-3 fw-bold">${name}</h5>
                <span class="badge bg-${getRoleBadgeColor(role)} fs-6">${getRoleLabel(role)}</span>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Nama Lengkap:</strong></td>
                        <td>${name}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><a href="mailto:${email}">${email}</a></td>
                    </tr>
                    <tr>
                        <td><strong>No. HP:</strong></td>
                        <td>${noHp ? '<a href="tel:' + noHp + '">' + noHp + '</a>' : '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>NIK:</strong></td>
                        <td>${nik || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>${alamat || '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Lahir:</strong></td>
                        <td>${tanggalLahir ? formatDate(tanggalLahir) : '-'}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin:</strong></td>
                        <td>${getGenderLabel(jenisKelamin)}</td>
                    </tr>
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td><span class="badge bg-${getRoleBadgeColor(role)}">${getRoleLabel(role)}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Terdaftar:</strong></td>
                        <td>${formatDate(createdAt)}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Update:</strong></td>
                        <td>${formatDate(updatedAt)}</td>
                    </tr>
                </table>
            </div>
        </div>
    `;
    document.getElementById('userDetailContent').innerHTML = content;
}
function editUser(userId, name, email, noHp, nik, alamat, tanggalLahir, jenisKelamin, role) {
    const content = `
        <form id="editUserForm" onsubmit="updateUser(event, ${userId})">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="${name}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="${email}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" class="form-control" name="no_hp" value="${noHp || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" value="${nik || ''}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="3">${alamat || ''}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="${tanggalLahir || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" ${jenisKelamin === 'L' ? 'selected' : ''}>Laki-laki</option>
                        <option value="P" ${jenisKelamin === 'P' ? 'selected' : ''}>Perempuan</option>
                    </select>
                </div>
            </div>
            ${role !== 'admin' ? `
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="masyarakat" ${role === 'masyarakat' ? 'selected' : ''}>Masyarakat</option>
                    <option value="kades" ${role === 'kades' ? 'selected' : ''}>Kepala Desa</option>
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
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    submitBtn.disabled = true;
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
            showAlert('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
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
function resetPassword(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin mereset password ${userName}?`)) {
        return;
    }
    const submitBtn = event?.target || document.activeElement;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;
    fetch(`/admin/data-pengguna/${userId}/reset-password`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const tempPassword = data.temp_password;
            const message = `Password berhasil direset!\n\nPassword Sementara: ${tempPassword}\n\n${data.note}`;
            alert(message);
            showAlert('success', `Password ${userName} berhasil direset. Password sementara: ${tempPassword}`);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat mereset password: ' + error.message);
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
}
function deleteUser(userId, userName) {
    if (!confirm(`Apakah Anda yakin ingin menghapus pengguna ${userName}? Tindakan ini tidak dapat dibatalkan.`)) {
        return;
    }
    const submitBtn = event?.target || document.activeElement;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;
    fetch(`/admin/data-pengguna/${userId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat menghapus pengguna: ' + error.message);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}
</script>
<!-- Modal Detail Pengguna -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Detail Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="userDetailContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Pengguna -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editUserContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection