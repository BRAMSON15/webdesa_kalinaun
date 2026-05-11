<header class="main-header">
    <a href="{{ route('masyarakat.dashboard') }}" class="logo"><b>Desa</b>Kalinaun</a>
    <nav class="navbar">
        <a href="#" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </a>
        <div class="navbar-right">
            <img src="https://via.placeholder.com/160" alt="User Image">
            <span>{{ auth()->user()->name ?? 'Masyarakat' }}</span>
        </div>
    </nav>
</header>