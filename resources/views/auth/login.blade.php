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
                <h1>Pilih Portal Login</h1>
                <p>Masuk sesuai dengan role Anda</p>
            </div>

            <!-- Role Selection Buttons -->
            <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                <a href="{{ route('masyarakat-login') }}" class="role-button" style="flex: 1;">
                    <i class="fas fa-users" style="font-size: 32px; margin-bottom: 10px; color: #28a745;"></i>
                    <h3 style="margin: 0 0 5px 0; font-size: 18px; color: #333;">Masyarakat</h3>
                    <p style="margin: 0; font-size: 13px; color: #666;">Login dengan Nama & NIK</p>
                </a>
                <a href="{{ route('admin-login') }}" class="role-button" style="flex: 1;">
                    <i class="fas fa-shield-alt" style="font-size: 32px; margin-bottom: 10px; color: #1f7e34;"></i>
                    <h3 style="margin: 0 0 5px 0; font-size: 18px; color: #333;">Admin/Kades</h3>
                    <p style="margin: 0; font-size: 13px; color: #666;">Login dengan Username</p>
                </a>
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

<style>
    .role-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 15px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .role-button:hover {
        border-color: #28a745;
        box-shadow: 0 8px 16px rgba(40, 167, 69, 0.15);
        transform: translateY(-4px);
    }

    .role-button:active {
        transform: translateY(-2px);
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
        .role-button {
            padding: 20px 12px;
        }

        .role-button i {
            font-size: 28px !important;
        }

        .role-button h3 {
            font-size: 16px !important;
        }

        .role-button p {
            font-size: 12px !important;
        }

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