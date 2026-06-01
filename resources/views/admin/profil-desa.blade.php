@extends('layouts.sipakal')
@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>
    <div class="dashboard-main">
        @include('admin.partials.header')
        <section class="dashboard-content">
            <!-- Enhanced Header with Breadcrumb -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola Profil Desa</li>
                            </ol>
                        </nav>
                        <h1 class="page-title">
                            <i class="fas fa-building gradient-icon"></i> 
                            Kelola Profil Desa
                        </h1>
                        <p class="page-subtitle">Kelola dan perbarui informasi lengkap profil desa</p>
                    </div>
                    <div class="col-auto">
                        <div class="page-actions">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-content">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <form action="{{ route('admin.profil-desa.update') }}" method="POST" class="form-modern">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Informasi Dasar -->
                    <div class="col-12 mb-4">
                        <div class="card card-modern">
                            <div class="card-header card-header-gradient-primary">
                                <div class="card-header-content">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <h5 class="card-title">Informasi Dasar Desa</h5>
                                        <p class="card-subtitle">Data identitas dan kontak desa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-map-marker-alt label-icon"></i>
                                                Nama Desa <span class="required">*</span>
                                            </label>
                                            <div class="input-wrapper">
                                                <input type="text" 
                                                       class="form-control form-control-modern @error('nama_desa') is-invalid @enderror" 
                                                       name="nama_desa" 
                                                       value="{{ old('nama_desa', $profil->nama_desa ?? '') }}" 
                                                       required 
                                                       placeholder="Masukkan nama desa">
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('nama_desa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-user-tie label-icon"></i>
                                                Nama Kepala Desa <span class="required">*</span>
                                            </label>
                                            <div class="input-wrapper">
                                                <input type="text" 
                                                       class="form-control form-control-modern @error('nama_kepala_desa') is-invalid @enderror" 
                                                       name="nama_kepala_desa" 
                                                       value="{{ old('nama_kepala_desa', $profil->nama_kepala_desa ?? '') }}" 
                                                       required 
                                                       placeholder="Masukkan nama kepala desa">
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('nama_kepala_desa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-home label-icon"></i>
                                                Alamat Desa <span class="required">*</span>
                                            </label>
                                            <div class="input-wrapper">
                                                <textarea class="form-control form-control-modern @error('alamat_desa') is-invalid @enderror" 
                                                          name="alamat_desa" 
                                                          rows="3" 
                                                          required 
                                                          placeholder="Masukkan alamat lengkap desa">{{ old('alamat_desa', $profil->alamat_desa ?? '') }}</textarea>
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('alamat_desa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-mail-bulk label-icon"></i>
                                                Kode Pos <span class="required">*</span>
                                            </label>
                                            <div class="input-wrapper">
                                                <input type="text" 
                                                       class="form-control form-control-modern @error('kode_pos') is-invalid @enderror" 
                                                       name="kode_pos" 
                                                       value="{{ old('kode_pos', $profil->kode_pos ?? '') }}" 
                                                       required 
                                                       placeholder="12345">
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('kode_pos')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-phone label-icon"></i>
                                                Telepon
                                            </label>
                                            <div class="input-wrapper">
                                                <input type="text" 
                                                       class="form-control form-control-modern @error('telepon') is-invalid @enderror" 
                                                       name="telepon" 
                                                       value="{{ old('telepon', $profil->telepon ?? '') }}" 
                                                       placeholder="021-1234567">
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <i class="fas fa-envelope label-icon"></i>
                                                Email
                                            </label>
                                            <div class="input-wrapper">
                                                <input type="email" 
                                                       class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                                       name="email" 
                                                       value="{{ old('email', $profil->email ?? '') }}" 
                                                       placeholder="desa@example.com">
                                                <div class="input-focus-border"></div>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Visi -->
                    <div class="col-md-6 mb-4">
                        <div class="card card-modern h-100">
                            <div class="card-header card-header-gradient-success">
                                <div class="card-header-content">
                                    <i class="fas fa-eye"></i>
                                    <div>
                                        <h5 class="card-title">Visi Desa</h5>
                                        <p class="card-subtitle">Pandangan masa depan desa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group-modern">
                                    <div class="input-wrapper">
                                        <textarea class="form-control form-control-modern @error('visi') is-invalid @enderror" 
                                                  name="visi" 
                                                  rows="8" 
                                                  placeholder="Masukkan visi desa yang menginspirasi dan memberikan arah untuk masa depan...">{{ old('visi', $profil->visi ?? '') }}</textarea>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    @error('visi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Misi -->
                    <div class="col-md-6 mb-4">
                        <div class="card card-modern h-100">
                            <div class="card-header card-header-gradient-info">
                                <div class="card-header-content">
                                    <i class="fas fa-bullseye"></i>
                                    <div>
                                        <h5 class="card-title">Misi Desa</h5>
                                        <p class="card-subtitle">Langkah strategis mencapai visi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group-modern">
                                    <div class="input-wrapper">
                                        <textarea class="form-control form-control-modern @error('misi') is-invalid @enderror" 
                                                  name="misi" 
                                                  rows="8" 
                                                  placeholder="Masukkan misi desa berupa langkah-langkah strategis untuk mencapai visi...">{{ old('misi', $profil->misi ?? '') }}</textarea>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    @error('misi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sejarah -->
                    <div class="col-12 mb-4">
                        <div class="card card-modern">
                            <div class="card-header card-header-gradient-warning">
                                <div class="card-header-content">
                                    <i class="fas fa-history"></i>
                                    <div>
                                        <h5 class="card-title">Sejarah Desa</h5>
                                        <p class="card-subtitle">Perjalanan dan perkembangan desa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group-modern">
                                    <div class="input-wrapper">
                                        <textarea class="form-control form-control-modern @error('sejarah') is-invalid @enderror" 
                                                  name="sejarah" 
                                                  rows="10" 
                                                  placeholder="Ceritakan sejarah singkat desa, mulai dari awal terbentuk hingga perkembangan saat ini...">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    @error('sejarah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="col-12">
                        <div class="card card-modern">
                            <div class="card-body text-center py-4">
                                <div class="action-buttons">
                                    <button type="submit" class="btn btn-primary btn-modern btn-lg">
                                        <i class="fas fa-save"></i>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-modern btn-lg">
                                        <i class="fas fa-times"></i>
                                        <span>Batal</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection