<aside class="dashboard-sidebar">
    <!-- Sidebar user panel -->
    <div class="sidebar-user-panel">
        <div class="image">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="info">
            <p>{{ auth()->user()->name ?? 'Kepala Desa' }}</p>
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
        <li class="sidebar-item {{ request()->routeIs('kades.dashboard') ? 'active-admin' : '' }}">
            <a href="{{ route('kades.dashboard') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-dashboard"></i> <span>Dashboard Kades</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('kades.profil*') ? 'active-admin' : '' }}">
            <a href="{{ route('kades.profil') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-user"></i> <span>Profil Sekdes</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('kades.validasi-pengajuan') || request()->routeIs('kades.detail-pengajuan') ? 'active-admin' : '' }}">
            <a href="{{ route('kades.validasi-pengajuan') }}" style="color: inherit; text-decoration: none; display: block; position: relative;">
                <i class="fa fa-check-circle"></i> <span>Validasi Pengajuan</span>
                @if(isset($stats['pengajuan_pending']) && $stats['pengajuan_pending'] > 0)
                    <span style="background: #f39c12; color: white; padding: 2px 6px; border-radius: 10px; font-size: 11px; margin-left: 5px; position: absolute; right: 10px;">{{ $stats['pengajuan_pending'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('kades.monitoring-pengaduan') ? 'active-admin' : '' }}">
            <a href="{{ route('kades.monitoring-pengaduan') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-chart-line"></i> <span>Monitoring Pengajuan</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('kades.laporan-arsip') ? 'active-admin' : '' }}">
            <a href="{{ route('kades.laporan-arsip') }}" style="color: inherit; text-decoration: none; display: block;">
                <i class="fa fa-file-archive"></i> <span>Lihat Laporan Arsip</span>
            </a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-item btn-keluar">
                    <i class="fa fa-sign-out-alt"></i> <span>Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</aside>
