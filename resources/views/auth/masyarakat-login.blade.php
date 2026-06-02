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
    </nav>

    <!-- Login Container -->
    <div class="auth-container">
        <div class="login-card">
            
            <div class="login-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="120" class="mb-3">
                <br>
                <h1>Masuk ke SIPAKAL</h1>
                <p>Portal Masyarakat</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('masyarakat-login.submit') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <i class="fas fa-user icon-left"></i>
                    <input type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">NIK (16 Digit)</label>
                    <i class="fas fa-id-card icon-left"></i>
                    <input type="text" class="form-input @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required>
                    @error('nik')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- <a href="{{ route('forgot-password') }}" class="forgot-password">lupa data login?</a> -->

                <button type="submit" class="btn-submit">masuk sekarang</button>
            </form>

            <div class="register-link">
                Belum punya akun ? <a href="{{ route('register') }}">Daftar disini</a>
            </div>

            <div class="register-link" style="margin-top: 15px; border-top: 1px solid #e0e0e0; padding-top: 15px;">
                Masuk sebagai <a href="{{ route('admin-login') }}">Admin/Kades</a>
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
    // Auto format NIK input - hanya angka
    document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
    });
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
