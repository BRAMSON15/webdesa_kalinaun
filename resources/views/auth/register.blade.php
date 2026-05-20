@extends('layouts.sipakal')

@section('title', 'Register - Sistem Desa')

@section('body')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="auth-page" id="authPage">
    <!-- Public Header -->
    <nav class="public-navbar">
        <div class="brand-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" class="me-2">
            <span>Desa Kalinaun</span>
        </div>
        <!-- <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="#" class="nav-link">Informasi desa</a>
            <a href="#" class="nav-link">profil desa</a>
            <a href="{{ route('login') }}" class="btn-masuk">
                <i class="fas fa-arrow-right"></i> masuk
            </a>
        </div> -->
    </nav>

    <!-- Register Container -->
    <div class="auth-container">
        <div class="register-card">
            
            <div class="register-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="120" class="mb-3">
                <br>
                <h1>Registrasi Akun Baru</h1>
                <p>Silakan lengkapi formulir di bawah ini untuk mendaftar</p>
            </div>

            @if($errors->any())
                <div class="error-alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="row-form">
                    <div class="col-half">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <i class="fas fa-user icon-left"></i>
                            <input type="text" class="form-input" name="name" placeholder="Sesuai KTP" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="form-group">
                            <label>Email</label>
                            <i class="fas fa-envelope icon-left"></i>
                            <input type="email" class="form-input" name="email" placeholder="Alamat email aktif" value="{{ old('email') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row-form">
                    <div class="col-half">
                        <div class="form-group">
                            <label>NIK</label>
                            <i class="fas fa-id-card icon-left"></i>
                            <input type="text" class="form-input" name="nik" placeholder="16 Digit NIK" value="{{ old('nik') }}" maxlength="16" required>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="form-group">
                            <label>No. HP (WhatsApp)</label>
                            <i class="fas fa-mobile-alt icon-left"></i>
                            <input type="text" class="form-input" name="no_hp" placeholder="Contoh: 081234..." value="{{ old('no_hp') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea class="form-input" name="alamat" rows="3" placeholder="Nama Jalan, RT/RW, Dusun" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="row-form">
                    <div class="col-half">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <i class="fas fa-calendar-alt icon-left"></i>
                            <input type="date" class="form-input" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-input" name="jenis_kelamin" style="padding-left: 16px;" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row-form">
                    <div class="col-half">
                        <div class="form-group">
                            <label>Kata Sandi</label>
                            <i class="fas fa-lock icon-left"></i>
                            <input type="password" class="form-input" name="password" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="form-group">
                            <label>Konfirmasi Sandi</label>
                            <i class="fas fa-lock icon-left"></i>
                            <input type="password" class="form-input" name="password_confirmation" placeholder="Ketik ulang sandi" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Sekarang
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk ke sini</a>
            </div>

        </div>
    </div>
</div>
@endsection