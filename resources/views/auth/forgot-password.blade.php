@extends('layouts.sipakal')

@section('body')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="auth-page">
    <!-- Public Header -->
    <nav class="public-navbar">
        <div class="brand-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" class="me-2">
            <span>Desa Kalinaun</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="#" class="nav-link">Informasi desa</a>
            <a href="#" class="nav-link">profil desa</a>
        </div>
    </nav>

    <!-- Forgot Password Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="120" class="mb-3">
                <br>
                <h1>Lupa Sandi?</h1>
                <p>Masukkan email Anda untuk menerima token reset password</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" style="padding: 12px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('forgot-password.send') }}">
                @csrf
                <div class="form-group">
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="email" class="form-input" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn-submit">Kirim Token Reset</button>
            </form>

            <div class="register-link">
                Ingat sandi Anda? <a href="{{ route('login') }}">Kembali ke login</a>
            </div>

        </div>
    </div>
</div>

@endsection
