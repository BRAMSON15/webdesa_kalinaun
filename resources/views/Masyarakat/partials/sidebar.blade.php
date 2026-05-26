<aside class="dashboard-sidebar">
    <!-- Sidebar user panel -->
    <div class="sidebar-user-panel">
        <div class="image">
            <i class="fas fa-user"></i>
        </div>
        <div class="info">
            <p>{{ auth()->user()->name ?? 'Masyarakat' }}</p>
            <a href="#"><i class="fa fa-circle text-success" style="color: #3c763d;"></i> Online</a>
        </div>
    </div>

    <!-- search form -->
    <form action="#" method="get" style="padding: 10px;">
        <div style="display: flex; background: #374850; border-radius: 3px;">
            <input type="text" name="q" placeholder="Search..." style="background: transparent; color: #666; border: none; padding: 10px; width: 100%; outline: none;">
            <button type="submit" style="background: transparent; color: #999; border: none; padding: 10px; cursor: pointer;"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <div class="sidebar-header">MAIN NAVIGATION</div>

    <ul class="sidebar-menu">
        <li class="sidebar-item {{ request()->routeIs('masyarakat.dashboard') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.dashboard') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-th-large"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.pengajuan-surat*') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.pengajuan-surat') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-file-signature"></i> <span>Pengajuan Surat</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.riwayat-pengajuan') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.riwayat-pengajuan') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-history"></i> <span>Riwayat Layanan</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.informasi-desa*') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.informasi-desa') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-bullhorn"></i> <span>Informasi Desa</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.pengaduan*') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.pengaduan.index') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-comments"></i> <span>Pengaduan</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.bansos*') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.bansos.index') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-hand-holding-heart"></i> <span>Bansos</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('masyarakat.profil*') ? 'active-masyarakat' : '' }}">
            <a href="{{ route('masyarakat.profil') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-user-cog"></i> <span>Pengaturan Akun</span>
            </a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-item btn-keluar" style="width: 100%; border: none; background: transparent; text-align: left; cursor: pointer;">
                    <i class="fa fa-sign-out-alt"></i> <span>Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</aside>