@extends('layouts.masyarakat')

@section('title', 'Notifikasi - SIPAKAL')

@section('content')
<style>
    :root {
        --primary-green: #28a745;
        --primary-dark: #1f7e34;
        --light-green: #c8e6c9;
        --very-light-green: #e8f5e9;
        --text-dark: #2d5016;
        --text-gray: #666;
        --border-light: #e0e0e0;
    }

    .page-container {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .content-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-header {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 8px 12px;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action:hover {
        background: var(--primary-dark);
    }

    .notification-item {
        background: var(--very-light-green);
        border-left: 4px solid var(--primary-green);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .notification-item:hover {
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
    }

    .notification-item.unread {
        background: #fff9e6;
        border-left-color: #ffc107;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .notification-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        flex: 1;
    }

    .notification-time {
        font-size: 0.75rem;
        color: #999;
        text-align: right;
    }

    .notification-body {
        font-size: 0.85rem;
        color: var(--text-gray);
        line-height: 1.4;
        margin-bottom: 8px;
    }

    .notification-footer {
        display: flex;
        gap: 8px;
    }

    .notification-link {
        padding: 4px 8px;
        background: var(--primary-green);
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .notification-link:hover {
        background: var(--primary-dark);
    }

    .notification-delete {
        padding: 4px 8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .notification-delete:hover {
        background: #c82333;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 1rem;
        margin: 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background: var(--light-green);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .back-btn:hover {
        background: #a5d6a7;
        transform: translateX(-3px);
    }

    @media (max-width: 576px) {
        .action-header {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .notification-header {
            flex-direction: column;
            gap: 4px;
        }

        .notification-footer {
            flex-wrap: wrap;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-bell"></i> Notifikasi</h4>
        <p>Kelola notifikasi Anda</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.dashboard') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="section-title">
            <i class="fas fa-inbox"></i> Semua Notifikasi
        </div>

        <div class="action-header">
            <form method="POST" action="{{ route('masyarakat.notifications.read-all') }}" style="flex: 1;">
                @csrf
                <button type="submit" class="btn-action">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
            <form method="POST" action="{{ route('masyarakat.notifications.delete-all') }}" style="flex: 1; margin-left: 10px;" onsubmit="return confirm('Hapus semua notifikasi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action" style="background: #dc3545;">
                    <i class="fas fa-trash"></i> Hapus Semua
                </button>
            </form>
        </div>

        @if(isset($notifications) && $notifications->count() > 0)
            @foreach($notifications as $notification)
            <div class="notification-item {{ !$notification->read_at ? 'unread' : '' }}">
                <div class="notification-header">
                    <div class="notification-title">{{ $notification->title ?? 'Notifikasi' }}</div>
                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                <p class="notification-body">{{ Str::limit($notification->message ?? '', 150) }}</p>
                <div class="notification-footer">
                    @if(!$notification->read_at)
                    <form method="POST" action="{{ route('masyarakat.notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit" class="notification-link">
                            <i class="fas fa-eye"></i> Tandai Dibaca
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('masyarakat.notifications.destroy', $notification->id) }}" onsubmit="return confirm('Hapus notifikasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="notification-delete">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada notifikasi</p>
        </div>
        @endif
    </div>
</div>

@endsection
