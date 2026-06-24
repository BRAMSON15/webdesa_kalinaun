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

    /* Override dashboard-content padding for this page */
    .container-fluid {
        padding: 0 !important;
    }

    /* Page Header - Full Width */
    .notification-page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin: -2rem -2rem 0 -2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .notification-page-header h5 {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 1.1rem;
        margin: 0;
    }

    .notification-page-header p {
        font-size: 0.9rem;
        margin: 5px 0 0 0;
        opacity: 0.95;
    }

    /* Content Container */
    .notification-content {
        background: white;
        padding: 20px;
        margin-top: 0;
    }

    /* Back Button */
    .notification-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: linear-gradient(135deg, var(--very-light-green) 0%, var(--light-green) 100%);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .notification-back-btn:hover {
        transform: translateX(-3px);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
    }

    /* Section Title */
    .notification-section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--very-light-green);
    }

    .notification-section-title i {
        color: var(--primary-green);
        font-size: 1.2rem;
    }

    /* Action Buttons */
    .notification-action-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .notification-action-btn {
        flex: 1;
        padding: 12px 16px;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        min-width: 150px;
    }

    .notification-action-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
    }

    .notification-action-btn.delete {
        background: #dc3545;
    }

    .notification-action-btn.delete:hover {
        background: #c82333;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
    }

    /* Notification List */
    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notification-card {
        background: white;
        border: 1px solid var(--border-light);
        border-left: 4px solid var(--primary-green);
        border-radius: 10px;
        padding: 14px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .notification-card:hover {
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.12);
        border-left-color: var(--primary-dark);
    }

    .notification-card.unread {
        background: linear-gradient(135deg, #fffbf0 0%, var(--very-light-green) 100%);
        border-left-color: #ffc107;
    }

    .notification-card.unread:hover {
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
    }

    .notification-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        gap: 12px;
    }

    .notification-card-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    .notification-card-time {
        font-size: 0.8rem;
        color: #999;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .notification-card-badge {
        display: inline-block;
        padding: 4px 10px;
        background: var(--primary-green);
        color: white;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .notification-card-body {
        font-size: 0.9rem;
        color: var(--text-gray);
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .notification-card-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .notification-card-action-btn {
        padding: 6px 12px;
        background: var(--very-light-green);
        color: var(--text-dark);
        border: 1px solid var(--light-green);
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        flex: 1;
        justify-content: center;
    }

    .notification-card-action-btn:hover {
        background: var(--light-green);
        box-shadow: 0 2px 6px rgba(40, 167, 69, 0.2);
    }

    .notification-card-delete-btn {
        padding: 6px 12px;
        background: #ffebee;
        color: #c82333;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        flex: 1;
        justify-content: center;
    }

    .notification-card-delete-btn:hover {
        background: #f5c6cb;
        box-shadow: 0 2px 6px rgba(220, 53, 69, 0.2);
    }

    /* Empty State */
    .notification-empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #999;
    }

    .notification-empty-state i {
        font-size: 64px;
        color: var(--very-light-green);
        margin-bottom: 15px;
    }

    .notification-empty-state p {
        font-size: 0.95rem;
        margin: 0;
        color: var(--text-gray);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .notification-page-header {
            margin: -1rem -1rem 0 -1rem;
            padding: 15px;
        }

        .notification-content {
            padding: 15px;
        }

        .notification-action-buttons {
            flex-direction: column;
        }

        .notification-action-btn {
            width: 100%;
            min-width: unset;
        }

        .notification-card-header {
            flex-direction: column;
            gap: 6px;
        }

        .notification-card-actions {
            gap: 6px;
        }

        .notification-card-action-btn,
        .notification-card-delete-btn {
            flex: 1;
            font-size: 0.75rem;
            padding: 5px 10px;
        }
    }
</style>

<!-- Page Header -->
<div class="notification-page-header">
    <h5><i class="fas fa-bell"></i> Notifikasi Anda</h5>
    <p>Kelola semua notifikasi di sini</p>
</div>

<!-- Content -->
<div class="notification-content">
    <!-- Back Button -->
    <a href="{{ route('masyarakat.dashboard') }}" class="notification-back-btn">
        <i class="fas fa-chevron-left"></i> Kembali ke Dashboard
    </a>

    <!-- Section Title -->
    <div class="notification-section-title">
        <i class="fas fa-inbox"></i> Daftar Notifikasi
    </div>

    <!-- Action Buttons -->
    @if(isset($notifications) && $notifications->count() > 0)
    <div class="notification-action-buttons">
        <form method="POST" action="{{ route('masyarakat.notifications.read-all') }}" style="flex: 1;">
            @csrf
            <button type="submit" class="notification-action-btn">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
        <form method="POST" action="{{ route('masyarakat.notifications.delete-all') }}" style="flex: 1;" onsubmit="return confirm('Hapus semua notifikasi? Tindakan ini tidak dapat dibatalkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="notification-action-btn delete">
                <i class="fas fa-trash"></i> Hapus Semua
            </button>
        </form>
    </div>
    @endif

    <!-- Notifications List -->
    @if(isset($notifications) && $notifications->count() > 0)
    <div class="notification-list">
        @foreach($notifications as $notification)
        <div class="notification-card {{ !$notification->read_at ? 'unread' : '' }}">
            <div class="notification-card-header">
                <div>
                    <div class="notification-card-title">{{ $notification->title ?? 'Notifikasi' }}</div>
                    <div class="notification-card-time">
                        <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
                @if($notification->type)
                <span class="notification-card-badge">{{ $notification->type }}</span>
                @endif
            </div>
            <p class="notification-card-body">{{ Str::limit($notification->message ?? '', 200) }}</p>
            <div class="notification-card-actions">
                @if(!$notification->read_at)
                <form method="POST" action="{{ route('masyarakat.notifications.read', $notification->id) }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="notification-card-action-btn">
                        <i class="fas fa-eye"></i> Tandai Dibaca
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('masyarakat.notifications.destroy', $notification->id) }}" onsubmit="return confirm('Hapus notifikasi ini?');" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="notification-card-delete-btn">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="notification-empty-state">
        <i class="fas fa-inbox"></i>
        <p>Tidak ada notifikasi</p>
        <p style="font-size: 0.85rem; margin-top: 8px; color: #ccc;">Semua notifikasi Anda akan muncul di sini</p>
    </div>
    @endif
</div>

@endsection
