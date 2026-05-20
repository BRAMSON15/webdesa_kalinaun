<aside class="dashboard-sidebar" style="background-color: #0f172a; color: #94a3b8; width: 230px; position: fixed; top: 50px; left: 0; height: calc(100vh - 50px); z-index: 800; transition: all 0.3s;">
    <!-- Sidebar user panel -->
    <div class="sidebar-user-panel p-3 d-flex align-items-center border-bottom border-secondary mb-3" style="border-color: rgba(255,255,255,0.05) !important;">
        <div class="image me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.1);">
            <i class="fas fa-user text-white"></i>
        </div>
        <div class="info overflow-hidden">
            <p class="mb-0 fw-bold text-white small text-truncate">{{ auth()->user()->name ?? 'Masyarakat' }}</p>
            <small class="text-success d-flex align-items-center gap-1" style="font-size: 0.65rem;">
                <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Online
            </small>
        </div>
    </div>

    <div class="sidebar-header px-3 py-2 small fw-bold text-uppercase opacity-50" style="font-size: 0.7rem; letter-spacing: 1px;">Menu Utama</div>

    <ul class="sidebar-menu list-unstyled p-0 m-0">
        <li class="sidebar-item-wrapper">
            <a href="{{ route('masyarakat.dashboard') }}" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none {{ request()->routeIs('masyarakat.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item-wrapper">
            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none {{ request()->routeIs('masyarakat.pengajuan-surat*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i> <span>Pengajuan Surat</span>
            </a>
        </li>
        <li class="sidebar-item-wrapper">
            <a href="{{ route('masyarakat.riwayat-pengajuan') }}" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none {{ request()->routeIs('masyarakat.riwayat-pengajuan') ? 'active' : '' }}">
                <i class="fas fa-history"></i> <span>Riwayat Layanan</span>
            </a>
        </li>
        <li class="sidebar-item-wrapper">
            <a href="{{ route('masyarakat.informasi-desa') }}" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none {{ request()->routeIs('masyarakat.informasi-desa*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> <span>Informasi Desa</span>
            </a>
        </li>
        <li class="sidebar-item-wrapper border-top border-secondary mt-2 pt-2" style="border-color: rgba(255,255,255,0.05) !important;">
            <a href="{{ route('masyarakat.profil') }}" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none {{ request()->routeIs('masyarakat.profil*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> <span>Pengaturan Akun</span>
            </a>
        </li>
        <li class="sidebar-item-wrapper mt-auto">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="sidebar-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none border-0 w-100 text-start bg-transparent" style="color: #ef4444;">
                    <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</aside>

<style>
    .sidebar-item {
        color: #94a3b8;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    .sidebar-item:hover {
        background-color: rgba(255,255,255,0.05);
        color: #ffffff;
    }
    .sidebar-item.active {
        background-color: rgba(34, 197, 94, 0.1);
        color: #22c55e;
        border-left-color: #22c55e;
        font-weight: 600;
    }
    .sidebar-item i {
        width: 20px;
        text-align: center;
    }
</style>