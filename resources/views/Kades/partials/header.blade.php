<header class="main-header">
    <a href="{{ route('kades.dashboard') }}" class="logo"><b>Desa</b>Kalinaun</a>
    <nav class="navbar">
        <a href="#" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </a>
        <div class="navbar-right">
            <img src="https://via.placeholder.com/160" alt="User Image">
            <span>{{ auth()->user()->name ?? 'Kepala Desa' }}</span>
        </div>
    </nav>
</header>