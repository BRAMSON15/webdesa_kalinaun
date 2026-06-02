@extends('layouts.masyarakat')

@section('title', 'Riwayat Pengajuan - SIPAKAL')

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

    .filter-section {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 12px;
        border: 1px solid var(--border-light);
        background: white;
        border-radius: 20px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
    }

    .filter-btn.active {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }

    .filter-btn:hover {
        border-color: var(--primary-green);
    }

    .pengajuan-item {
        background: var(--very-light-green);
        border-left: 4px solid var(--primary-green);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .pengajuan-item:hover {
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
    }

    .pengajuan-info small {
        display: block;
        color: #999;
        font-size: 0.75rem;
        margin-bottom: 4px;
    }

    .pengajuan-info div {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .pengajuan-status {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge {
        font-size: 0.7rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-align: center;
        min-width: 70px;
    }

    .badge-primary {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .action-link {
        padding: 6px 12px;
        background: var(--primary-green);
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .action-link:hover {
        background: var(--primary-dark);
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
        .pengajuan-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .pengajuan-status {
            width: 100%;
            justify-content: space-between;
        }

        .action-link {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-history"></i> Riwayat Pengajuan Surat</h4>
        <p>Lihat semua pengajuan surat Anda</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.dashboard') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        @if(isset($pengajuans) && $pengajuans->count() > 0)
            <div class="section-title">
                <i class="fas fa-list"></i> Daftar Pengajuan Anda
            </div>

            <!-- Filter -->
            <div class="filter-section">
                <button class="filter-btn active" onclick="filterStatus('all')">Semua</button>
                <button class="filter-btn" onclick="filterStatus('diproses')">Diproses</button>
                <button class="filter-btn" onclick="filterStatus('disetujui')">Disetujui</button>
                <button class="filter-btn" onclick="filterStatus('ditolak')">Ditolak</button>
            </div>

            <!-- Items -->
            @foreach($pengajuans as $pengajuan)
            <div class="pengajuan-item">
                <div class="pengajuan-info">
                    <small>{{ $pengajuan->created_at->format('d M Y H:i') }}</small>
                    <div>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat' }}</div>
                </div>
                <div class="pengajuan-status">
                    @if($pengajuan->status === 'diproses')
                        <span class="badge badge-warning">Diproses</span>
                    @elseif($pengajuan->status === 'disetujui')
                        <span class="badge badge-success">Disetujui</span>
                    @elseif($pengajuan->status === 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-primary">{{ ucfirst($pengajuan->status) }}</span>
                    @endif
                    <a href="{{ route('masyarakat.detail-pengajuan', $pengajuan->id) }}" class="action-link">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada pengajuan surat</p>
        </div>
        @endif
    </div>
</div>

<script>
    function filterStatus(status) {
        // Update button active state
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // Filter items (simplified - can be improved with backend filtering)
        if (status === 'all') {
            document.querySelectorAll('.pengajuan-item').forEach(item => {
                item.style.display = 'flex';
            });
        } else {
            document.querySelectorAll('.pengajuan-item').forEach(item => {
                const badge = item.querySelector('.badge');
                const isMatch = badge.textContent.trim().toLowerCase() === status.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
                item.style.display = isMatch ? 'flex' : 'none';
            });
        }
    }
</script>

@endsection
