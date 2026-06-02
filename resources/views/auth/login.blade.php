@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-page" id="authPage">
    <!-- Public Header -->
    <nav class="public-navbar">
        <div class="brand-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" class="me-2">
            <span>Desa Kalinaun</span>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="120" class="mb-3">
                <br>
                <h1 id="titleText">Masuk ke SIPAKAL</h1>
                <p id="descText">Gunakan Email untuk masuk</p>
            </div>

            <!-- Fake Toggle just for visual requirement of Sketch 2 -->
            <div class="role-toggle-container">
                <div class="role-toggle">
                    <button type="button" class="role-btn active-role-masyarakat" id="btnMasyarakat" onclick="switchRole('masyarakat')">Masyarakat</button>
                    <button type="button" class="role-btn" id="btnAdmin" onclick="switchRole('admin')">Admin/Kades</button>
                </div>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('masyarakat-login.submit') }}" id="loginForm">
                @csrf
                <input type="hidden" name="role" id="loginRole" value="{{ old('role', 'masyarakat') }}">
                
                <div class="form-group">
                    <i class="fas fa-user icon-left" id="iconUsername"></i>
                    <input type="text" class="form-input" name="name" id="usernameInput" placeholder="Masukkan Nama Lengkap" value="{{ old('name') ?: old('email') }}" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock icon-left" id="iconPassword"></i>
                    <input type="password" class="form-input" name="nik" id="passwordInput" placeholder="Masukkan NIK" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword(this)"></i>
                </div>

                <!-- <a href="{{ route('forgot-password') }}" class="forgot-password">lupa sandi?</a> -->

                <button type="submit" class="btn-submit" id="submitBtn">masuk sekarang</button>
            </form>

            <div class="register-link" id="registerLink">
                Belum punya akun ? <a href="{{ route('register') }}">Daftar disini</a>
            </div>

            <div class="back-home-button-container">
                <a href="{{ route('home') }}" class="btn-back-home">
                    <i class="fas fa-home"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePassword(icon) {
        let input = icon.previousElementSibling;
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function switchRole(role) {
        const page = document.getElementById('authPage');
        const btnMasyarakat = document.getElementById('btnMasyarakat');
        const btnAdmin = document.getElementById('btnAdmin');
        
        const loginForm = document.getElementById('loginForm');
        const loginRole = document.getElementById('loginRole');
        const usernameInput = document.getElementById('usernameInput');
        const passwordInput = document.getElementById('passwordInput');
        const iconUsername = document.getElementById('iconUsername');
        
        const descText = document.getElementById('descText');
        const registerLink = document.getElementById('registerLink');

        loginRole.value = role;

        if (role === 'admin') {
            page.classList.add('admin-mode');
            
            btnAdmin.classList.add('active-role-admin');
            btnMasyarakat.classList.remove('active-role-masyarakat');
            btnMasyarakat.style.color = 'var(--text-muted)';
            
            loginForm.action = "{{ route('admin-login.submit') }}";
            
            usernameInput.name = 'email';
            usernameInput.placeholder = 'Masukkan Username';
            iconUsername.className = 'fas fa-user icon-left';
            
            passwordInput.name = 'password';
            passwordInput.placeholder = 'Masukkan Kata Sandi';
            
            descText.textContent = 'masuk sebagai admin atau kades';
            registerLink.style.display = 'none';

        } else {
            page.classList.remove('admin-mode');
            
            btnMasyarakat.classList.add('active-role-masyarakat');
            btnAdmin.classList.remove('active-role-admin');
            btnAdmin.style.color = 'var(--text-muted)';
            
            loginForm.action = "{{ route('masyarakat-login.submit') }}";
            
            usernameInput.name = 'name';
            usernameInput.placeholder = 'Masukkan Nama Lengkap';
            iconUsername.className = 'fas fa-user icon-left';
            
            passwordInput.name = 'nik';
            passwordInput.placeholder = 'Masukkan NIK';
            
            descText.textContent = 'gunakan Nama Lengkap & NIK untuk masuk';
            registerLink.style.display = 'block';
        }
    }

    // Initialize state based on old input
    window.onload = function() {
        const currentRole = document.getElementById('loginRole').value;
        if (currentRole === 'admin') {
            switchRole('admin');
        }
    };
</script>

<style>
    .back-home-button-container {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e8e8e8;
    }

    .btn-back-home {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px 20px;
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        color: #333;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-back-home:hover {
        background: linear-gradient(135deg, #eeeeee 0%, #f5f5f5 100%);
        border-color: #999;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .btn-back-home:active {
        transform: translateY(0);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-back-home i {
        font-size: 18px;
        color: #28a745;
    }

    .btn-back-home span {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    @media (max-width: 576px) {
        .back-home-button-container {
            margin-top: 20px;
            padding-top: 15px;
        }

        .btn-back-home {
            padding: 12px 16px;
            font-size: 0.9rem;
        }

        .btn-back-home i {
            font-size: 16px;
        }
    }
</style>
@endsection