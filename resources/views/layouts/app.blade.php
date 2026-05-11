<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Desa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body style="background-color: #f8f9fa; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top"
        style="box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-bottom: 1px solid rgba(46, 204, 113, 0.2);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"
                style="color: #27ae60; font-size: 1.5rem; letter-spacing: -0.5px;">
                <i class="fas fa-leaf text-success"></i> Desa Kalinaun
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ps-3" style="border-left: 2px solid #eee; margin-left: 10px;">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(auth()->user()->isKades())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kades.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(auth()->user()->isMasyarakat())
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" href="{{ route('masyarakat.dashboard') }}"
                                    style="color: #2c3e50;">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" style="color: #2c3e50;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2ecc71&color=fff"
                                    alt="User" class="rounded-circle me-2" width="30" height="30">
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isKades())
                                    <span class="badge bg-success ms-2 d-none d-lg-inline">Kepala Desa</span>
                                @elseif(auth()->user()->isAdmin())
                                    <span class="badge bg-danger ms-2 d-none d-lg-inline">Admin</span>
                                @elseif(auth()->user()->isMasyarakat())
                                    <span class="badge bg-info ms-2 d-none d-lg-inline">Masyarakat</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                @elseif(auth()->user()->isKades())
                                    <li><a class="dropdown-item" href="{{ route('kades.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('kades.profil') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                                @elseif(auth()->user()->isMasyarakat())
                                    <li><a class="dropdown-item" href="{{ route('masyarakat.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('masyarakat.profil') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- <li class="nav-item me-2">
                            <a class="nav-link fw-bold" href="{{ route('login') }}" style="color: #27ae60;">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-warning rounded-pill px-4 fw-bold" href="{{ route('register') }}" 
                               style="background-color: #f1c40f; border:none; box-shadow: 0 4px 10px rgba(241, 196, 15, 0.3);">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li> -->
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="w-100 p-0 m-0">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>