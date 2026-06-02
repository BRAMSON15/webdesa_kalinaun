<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPAKAL')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/kalinaun.css') }}" rel="stylesheet">
    <link href="{{ asset('css/views-custom.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="#"><i class="fas fa-phone me-2"></i> 0822-9176-3634</a>
                    <a href="#"><i class="fas fa-envelope me-2"></i> desakalinaunliktim@gmail.com</a>
                </div>
                <div>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    @auth
                        <span class="ms-3 text-white-50 small">Selamat datang, {{ auth()->user()->name }}</span>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-xl sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="45" class="me-2">
                <div class="d-flex flex-column">
                    <span class="lh-1">Desa Kalinaun</span>
                    <small style="font-size: 0.65rem; color: var(--text-muted); font-weight: 400;">Kab. Minahasa Utara</small>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
</ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-primary-premium dropdown-toggle py-2 px-4" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i> Akun Saya
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <h6 class="dropdown-header">Role: 
                                        @if(auth()->user()->isAdmin()) Admin
                                        @elseif(auth()->user()->isKades()) Kades
                                        @else Masyarakat
                                        @endif
                                    </h6>
                                </li>
                                <li>
                                    @if(auth()->user()->isAdmin())
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                                    @elseif(auth()->user()->isKades())
                                        <a class="dropdown-item" href="{{ route('kades.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('masyarakat.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                                    @endif
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-premium py-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary-premium py-2">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-info pe-lg-4">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="60" class="mb-4">
                        <h4 class="text-white mb-3">Pemerintah Desa Kalinaun</h4>
                        <p class="mb-4">Sistem Informasi Desa yang dirancang untuk mempercepat pelayanan publik dan transparansi data kependudukan.</p>
                        <div class="social-links d-flex gap-3">
                            <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-heading">Profil Desa</h5>
                    <ul class="footer-links">
                        <li><a href="#">Sejarah Desa</a></li>
                        <li><a href="#">Visi & Misi</a></li>
                        <li><a href="#">Struktur Organisasi</a></li>
                        <li><a href="#">Geografis Desa</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-heading">Layanan Publik</h5>
                    <ul class="footer-links">
                        <li><a href="#">Pengajuan Surat</a></li>
                        <li><a href="#">Informasi Publik</a></li>
                        <li><a href="#">Layanan Mandiri</a></li>
                        <li><a href="#">Lapak Desa</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="footer-heading">Kontak Kami</h5>
                    <ul class="footer-links">
                        <li class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt mt-1 me-3 text-primary"></i>
                            <span>Jl. Likupang - Girian, Kec. Likupang Timur, Kab. Minahasa Utara, Sulawesi Utara</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-phone me-3 text-primary"></i>
                            <span>0822-9176-3634</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-envelope me-3 text-primary"></i>
                            <span>desakalinaunliktim@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Desa Kalinaun. All Rights Reserved. <br> <span class="opacity-50 small">Design by RumahDesa.Net</span></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
