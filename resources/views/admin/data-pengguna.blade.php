@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <header class="main-header">
            <a href="" class="logo"><b>Desa</b>Kalinaun</a>
            <nav class="navbar">
                <div class="navbar-right">
                    <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                </div>
            </nav>
        </header>

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1>Kelola Data Pengguna</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Terdaftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if($user->no_hp)
                                                        <br><small class="text-muted">{{ $user->no_hp }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role == 'kades')
                                                <span class="badge bg-warning">Kepala Desa</span>
                                            @else
                                                <span class="badge bg-info">Masyarakat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info" onclick="viewUser({{ $user->id }})">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                @if($user->role != 'admin')
                                                    <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})">
                                                        <i class="fas fa-edit"></i> Edit
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
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pengguna.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<script>
function viewUser(id) {
    alert('Detail pengguna ID: ' + id);
}

function editUser(id) {
    alert('Edit pengguna ID: ' + id);
}
</script>
@endsection