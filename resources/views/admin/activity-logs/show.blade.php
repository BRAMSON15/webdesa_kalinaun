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
                <h1><i class="fas fa-info-circle me-2"></i>Activity Log Detail</h1>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-info"></i> Informasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Waktu</label>
                                    <p class="form-control-plaintext">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">User</label>
                                    <p class="form-control-plaintext">
                                        @if($log->user)
                                            {{ $log->user->name }}
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Action</label>
                                    <p class="form-control-plaintext">
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
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Model Type</label>
                                    <p class="form-control-plaintext">{{ $log->model_type }} (ID: {{ $log->model_id }})</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <p class="form-control-plaintext">{{ $log->description }}</p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">IP Address</label>
                                    <p class="form-control-plaintext">{{ $log->ip_address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($log->old_values || $log->new_values)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-exchange-alt"></i> Changes</h5>
                        </div>
                        <div class="card-body">
                            @if($log->old_values)
                            <div class="mb-3">
                                <h6>Old Values</h6>
                                <pre class="bg-light p-3 rounded">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            @endif

                            @if($log->new_values)
                            <div class="mb-3">
                                <h6>New Values</h6>
                                <pre class="bg-light p-3 rounded">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection
