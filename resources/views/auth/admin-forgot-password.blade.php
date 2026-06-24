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

    <!-- Forgot Password Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <div style="width: 75px; height: 75px; background-color: var(--bg-body); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 35px; color: var(--primary-color); margin-bottom: 1rem; border: 2px solid var(--border-box);">
                    <i class="fas fa-key"></i>
                </div>
                <br>
                <h1>Lupa Sandi</h1>
                <p>Masukkan email admin/kades Anda</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin-forgot-password.send') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="email" class="form-input @error('email') is-invalid @enderror" name="email" placeholder="Masukkan email admin/kades" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Kirim Token Reset</button>
            </form>

            <div class="register-link">
                <a href="{{ route('admin-login') }}">Kembali ke login</a>
            </div>

        </div>
    </div>
</div>

@endsection
