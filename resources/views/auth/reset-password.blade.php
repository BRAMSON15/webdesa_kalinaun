@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-page">
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

    <!-- Reset Password Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <div style="width: 75px; height: 75px; background-color: var(--bg-body); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 35px; color: var(--primary-color); margin-bottom: 1rem; border: 2px solid var(--border-box);">
                    <i class="fas fa-lock"></i>
                </div>
                <br>
                <h1>Reset Sandi</h1>
                <p>Masukkan sandi baru Anda</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('reset-password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <i class="fas fa-key icon-left"></i>
                    <input type="text" class="form-input" value="{{ $resetToken }}" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                    <small style="display: block; margin-top: 5px; color: #666;">Token reset (disalin otomatis)</small>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" class="form-input" name="password" placeholder="Masukkan sandi baru" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword(this)"></i>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" class="form-input" name="password_confirmation" placeholder="Konfirmasi sandi baru" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword(this)"></i>
                </div>

                <button type="submit" class="btn-submit">Reset Sandi</button>
            </form>

            <div class="register-link">
                <a href="{{ route('login') }}">Kembali ke login</a>
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

    // Auto copy token to clipboard
    document.addEventListener('DOMContentLoaded', function() {
        const tokenInput = document.querySelector('input[readonly]');
        if (tokenInput) {
            tokenInput.addEventListener('click', function() {
                this.select();
                document.execCommand('copy');
                alert('Token disalin ke clipboard!');
            });
        }
    });
</script>

@endsection
