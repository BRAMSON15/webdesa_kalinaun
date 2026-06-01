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
                    <label class="form-label">Email</label>
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
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

                <a href="{{ route('forgot-password') }}" class="forgot-password">lupa password?</a>

                <button type="submit" class="btn-submit">masuk sekarang</button>
            </form>

            <div class="register-link">
                Kembali ke <a href="{{ route('masyarakat-login') }}">Portal Masyarakat</a>
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
</style>
@endsection
