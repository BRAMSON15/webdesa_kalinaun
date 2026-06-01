<!-- Sidebar user panel -->
<div class="sidebar-user-panel">
    <div class="image">
        <i class="fas fa-user"></i>
    </div>
    <div class="info">
        <p>{{ auth()->user()->name ?? 'Administrator' }}</p>
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
    <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.profil-desa*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.profil-desa') }}">
            <i class="fa fa-user"></i> <span>Kelola Profil Desa</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.pengajuan-surat*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.pengajuan-surat') }}">
            <i class="fa fa-file"></i> <span>Status Pengajuan</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.informasi-desa*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.informasi-desa') }}">
            <i class="fa fa-envelope"></i> <span>Kelola Informasi Desa</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.data-pengguna*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.data-pengguna') }}">
            <i class="fa fa-users"></i> <span>Kelola Data Pengguna</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.jenis-surat*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.jenis-surat') }}">
            <i class="fa fa-exchange-alt"></i> <span>Kelola Jenis Surat</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.arsip-dokumen*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.arsip-dokumen') }}">
            <i class="fa fa-archive"></i> <span>Kelola Arsip Dokumen</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.pengaduan*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.pengaduan.index') }}">
            <i class="fa fa-comments"></i> <span>Kelola Pengaduan</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.bansos*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.bansos.index') }}">
            <i class="fa fa-hand-holding-heart"></i> <span>Kelola Bansos</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.tanda-tangan*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.tanda-tangan.index') }}">
            <i class="fa fa-signature"></i> <span>Tanda Tangan (TTE)</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('admin.analytics*') ? 'active-admin' : '' }}">
        <a href="{{ route('admin.analytics') }}">
            <i class="fa fa-chart-line"></i> <span>Analytics & Laporan</span>
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