@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-page admin-mode">
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
                <h1>Masuk ke SIPAKAL</h1>
                <p>Portal Admin & Kades</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin-login.submit') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <i class="fas fa-user icon-left"></i>
                    <input type="text" class="form-input @error('email') is-invalid @enderror" name="email" placeholder="Masukkan username Anda" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword(this)"></i>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('admin-forgot-password') }}" class="forgot-password">lupa password?</a>

                <button type="submit" class="btn-submit">masuk sekarang</button>
            </form>

            <div class="register-link">
                Kembali ke <a href="{{ route('masyarakat-login') }}">Portal Masyarakat</a>
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
</script>

<style>
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }

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
