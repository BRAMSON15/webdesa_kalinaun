@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-page" id="authPage">
    <!-- Public Header -->
    <nav class="public-navbar">
        <div class="brand-logo">
            <div style="width: 40px; height: 40px; background-color: var(--primary-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white;">
                <i class="fas fa-tree"></i>
            </div>
            <span>Desa Kalinaun</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="#" class="nav-link">Informasi desa</a>
            <a href="#" class="nav-link">profil desa</a>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <div style="width: 75px; height: 75px; background-color: var(--bg-body); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 35px; color: var(--primary-color); margin-bottom: 1rem; border: 2px solid var(--border-box);">
                    <i class="fas fa-tree"></i>
                </div>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="text" class="form-input" name="email" id="emailInput" placeholder="Masukan NIK atau Email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" class="form-input" name="password" placeholder="masukkan kata sandi" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword(this)"></i>
                </div>

                <a href="{{ route('forgot-password') }}" class="forgot-password">lupa sandi?</a>

                <button type="submit" class="btn-submit" id="submitBtn">masuk sekarang</button>
            </form>

            <div class="register-link" id="registerLink">
                Belum punya akun ? <a href="{{ route('register') }}">Daftar disini</a>
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
        const emailInput = document.getElementById('emailInput');
        const descText = document.getElementById('descText');
        const registerLink = document.getElementById('registerLink');

        if (role === 'admin') {
            page.classList.add('admin-mode');
            
            btnAdmin.classList.add('active-role-admin');
            btnMasyarakat.classList.remove('active-role-masyarakat');
            btnMasyarakat.style.color = 'var(--text-muted)';
            
            emailInput.placeholder = 'Masukkan Username / Email';
            descText.textContent = 'masuk sebagai admin atau kades';
            registerLink.style.display = 'none';

        } else {
            page.classList.remove('admin-mode');
            
            btnMasyarakat.classList.add('active-role-masyarakat');
            btnAdmin.classList.remove('active-role-admin');
            btnAdmin.style.color = 'var(--text-muted)';
            
            emailInput.placeholder = 'Masukan NIK atau Email';
            descText.textContent = 'gunakan NIK/Email untuk masuk';
            registerLink.style.display = 'block';
        }
    }
</script>
@endsection