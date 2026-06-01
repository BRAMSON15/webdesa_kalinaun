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
                <h1><i class="fas fa-history me-2"></i>Activity Log</h1>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5><i class="fas fa-filter"></i> Filter</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Action</label>
                            <select name="action" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model Type</label>
                            <select name="model_type" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="Pengaduan" {{ request('model_type') === 'Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                <option value="Bansos" {{ request('model_type') === 'Bansos' ? 'selected' : '' }}>Bansos</option>
                                <option value="PenerimaBansos" {{ request('model_type') === 'PenerimaBansos' ? 'selected' : '' }}>Penerima Bansos</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Activity Logs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Model</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        @if($log->user)
                                            <strong>{{ $log->user->name }}</strong>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($log->action)
                                            @case('create')
                                                <span class="badge bg-success">Create</span>
                                                @break
                                            @case('update')
                                                <span class="badge bg-info">Update</span>
                                                @break
                                            @case('delete')
                                                <span class="badge bg-danger">Delete</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $log->action }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $log->model_type }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td><small>{{ $log->ip_address }}</small></td>
                                    <td>
                                        <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Tidak ada activity log
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $logs->links() }}
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
