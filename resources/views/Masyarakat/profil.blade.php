@extends('layouts.masyarakat')

@section('title', 'Profil Saya - SIPAKAL')

@section('content')
<style>
    :root {
        --primary-green: #28a745;
        --primary-dark: #1f7e34;
        --light-green: #c8e6c9;
        --very-light-green: #e8f5e9;
        --text-dark: #2d5016;
        --text-gray: #666;
        --border-light: #e0e0e0;
    }

    .page-container {
        background: #f5f5f5;
        padding-bottom: 100px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        color: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .content-section {
        padding: 15px;
        margin-bottom: 10px;
        background: white;
        border-radius: 8px;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-green) 0%, #20c997 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 40px;
    }

    .profile-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .profile-role {
        font-size: 0.85rem;
        color: var(--text-gray);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        outline: none;
    }

    .form-text {
        font-size: 0.8rem;
        color: var(--text-gray);
        margin-top: 4px;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        flex: 1;
        padding: 12px 15px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #1f7e34 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1f7e34 0%, #15572e 100%);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--light-green);
        color: var(--text-dark);
    }

    .btn-secondary:hover {
        background: #a5d6a7;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background: var(--light-green);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .back-btn:hover {
        background: #a5d6a7;
        transform: translateX(-3px);
    }

    @media (max-width: 576px) {
        .btn-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <!-- Header -->
    <div class="page-header">
        <h4><i class="fas fa-user"></i> Profil Saya</h4>
        <p>Kelola data profil dan keamanan akun Anda</p>
    </div>

    <!-- Back Button -->
    <div style="padding: 0 15px;">
        <a href="{{ route('masyarakat.dashboard') }}" class="back-btn">
            <i class="fas fa-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <div style="flex: 1;">
                <div style="font-weight: 600; margin-bottom: 8px;">
                    <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                </div>
                <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-role">Masyarakat</div>
        </div>

        <!-- Profile Form -->
        <form action="{{ route('masyarakat.profil.update') }}" method="PUT" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i> Nama Lengkap
                </label>
                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-phone"></i> Nomor HP
                </label>
                <input type="tel" class="form-control" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-id-card"></i> NIK
                </label>
                <input type="text" class="form-control" value="{{ auth()->user()->nik ?? '-' }}" disabled>
                <div class="form-text">NIK tidak dapat diubah</div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-map-marker-alt"></i> Alamat
                </label>
                <textarea class="form-control" name="alamat" rows="3">{{ auth()->user()->alamat ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-birthday-cake"></i> Tanggal Lahir
                </label>
                <input type="date" class="form-control" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-venus-mars"></i> Jenis Kelamin
                </label>
                <select class="form-control" name="jenis_kelamin">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ auth()->user()->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ auth()->user()->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>

        <!-- Change Password Section -->
        <hr style="margin: 20px 0; border: none; border-top: 1px solid var(--border-light);">

        <h6 style="font-weight: 600; color: var(--text-dark); margin-bottom: 15px;">
            <i class="fas fa-lock"></i> Ubah Password
        </h6>

        <form action="{{ route('masyarakat.profil.update-password') }}" method="PUT">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-key"></i> Password Saat Ini
                </label>
                <input type="password" class="form-control" name="current_password" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Password Baru
                </label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Konfirmasi Password Baru
                </label>
                <input type="password" class="form-control" name="password_confirmation" required>
                <div class="form-text">Minimal 8 karakter</div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Perbarui Password
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
