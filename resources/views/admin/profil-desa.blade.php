@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<style>
/* Modern Form Styling */
.form-modern {
    --primary-color: #3498db;
    --success-color: #2ecc71;
    --info-color: #17a2b8;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --light-color: #f8f9fa;
    --dark-color: #2c3e50;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.breadcrumb {
    background: rgba(255,255,255,0.1);
    border-radius: 25px;
    padding: 8px 20px;
    margin-bottom: 15px;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.gradient-icon {
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 2.2rem;
}

.page-subtitle {
    margin: 10px 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.card-modern {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.card-header-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 25px 30px;
}

.card-header-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    padding: 25px 30px;
}

.card-header-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 25px 30px;
}

.card-header-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border: none;
    padding: 25px 30px;
}

.card-header-content {
    display: flex;
    align-items: center;
    gap: 15px;
    color: white;
}

.card-header-content i {
    font-size: 1.5rem;
    opacity: 0.9;
}

.card-title {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
}

.card-subtitle {
    margin: 5px 0 0 0;
    opacity: 0.8;
    font-size: 0.9rem;
}

.card-body {
    padding: 30px;
}

.form-group-modern {
    margin-bottom: 25px;
}

.form-label-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 12px;
    font-size: 0.95rem;
}

.label-icon {
    color: var(--primary-color);
    font-size: 1rem;
}

.required {
    color: var(--danger-color);
    font-weight: bold;
}

.input-wrapper {
    position: relative;
}

.form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 15px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-control-modern:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    transform: translateY(-2px);
}

.input-focus-border {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--info-color));
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 2px;
}

.form-control-modern:focus + .input-focus-border {
    width: 100%;
}

.btn-modern {
    border-radius: 12px;
    padding: 15px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-primary.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-secondary.btn-modern {
    background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.alert-modern {
    border: none;
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.alert-icon {
    font-size: 1.5rem;
    margin-top: 2px;
}

.alert-content {
    flex: 1;
}

.alert-success.alert-modern {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger.alert-modern {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-modern {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-modern {
    animation: slideInUp 0.6s ease-out;
}

.card-modern:nth-child(2) { animation-delay: 0.1s; }
.card-modern:nth-child(3) { animation-delay: 0.2s; }
.card-modern:nth-child(4) { animation-delay: 0.3s; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection