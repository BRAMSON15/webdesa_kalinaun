@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-bell"></i> Notifikasi</h2>
        </div>
        <div class="col-md-4 text-right">
            @if($notifications->count() > 0)
                <form action="{{ route('masyarakat.notifications.read-all') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                    </button>
                </form>
                <form action="{{ route('masyarakat.notifications.delete-all') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus semua notifikasi?')">
                        <i class="fas fa-trash"></i> Hapus Semua
                    </button>
                </form>
            @endif
            <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if($notifications->count() > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Notifikasi</h5>
            </div>
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <div class="list-group-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-primary">Baru</span>
                                    @endif
                                    <h6 class="mb-0">{{ $notification->title }}</h6>
                                </div>
                                <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="ms-2">
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('masyarakat.notifications.read', $notification) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('masyarakat.notifications.destroy', $notification) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada notifikasi</p>
            </div>
        </div>
    @endif
</div>
@endsection
