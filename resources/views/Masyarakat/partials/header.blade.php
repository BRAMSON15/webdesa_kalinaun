<header class="main-header">
    <a href="{{ route('home') }}" class="logo d-flex align-items-center" style="justify-content: center; padding: 0;">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" class="me-2">
        <b>Desa</b> Kalinaun
    </a>
    <nav class="navbar">
        <a href="#" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </a>
        <div class="navbar-right">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=22c55e&color=fff" alt="User Image">
            <span>{{ auth()->user()->name ?? 'Masyarakat' }}</span>
        </div>
    </nav>
</header>