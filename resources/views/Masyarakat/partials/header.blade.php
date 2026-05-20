<header class="main-header" style="background-color: #ffffff; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; height: 50px; position: fixed; top: 0; width: 100%; z-index: 1000;">
    <a href="{{ route('home') }}" class="logo d-flex align-items-center" style="background-color: #22c55e; padding: 0 20px; color: white; text-decoration: none; width: 230px; height: 50px;">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" class="me-2">
        <span class="fw-bold" style="font-size: 0.9rem; letter-spacing: 0.5px;">DESA KALINAUN</span>
    </a>
    <nav class="navbar px-3 d-flex justify-content-between align-items-center" style="flex: 1; height: 50px;">
        <a href="#" class="sidebar-toggle text-dark" style="font-size: 1.2rem; text-decoration: none;">
            <i class="fas fa-bars"></i>
        </a>
        <div class="navbar-right d-flex align-items-center gap-3">
            <div class="d-none d-md-block text-end">
                <div class="fw-bold small lh-1" style="font-size: 0.85rem;">{{ auth()->user()->name ?? 'Masyarakat' }}</div>
                <small class="text-muted" style="font-size: 0.7rem;">Masyarakat</small>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=22c55e&color=fff" 
                 alt="User Image" class="rounded-circle border" width="35" height="35">
        </div>
    </nav>
</header>