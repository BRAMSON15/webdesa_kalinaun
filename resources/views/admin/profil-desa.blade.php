@extends('layouts.sipakal')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">

<div class="wrapper">
    <aside class="dashboard-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    <div class="dashboard-main">
        <header class="main-header">
            <a href="" class="logo"><b>Desa</b>Kalinaun</a>
            <nav class="navbar">
                <div class="navbar-right">
                    <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                </div>
            </nav>
        </header>

        <section class="dashboard-content">
            <div class="dashboard-header">
                <h1>Kelola Profil Desa</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Profil Desa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-desa.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Desa</label>
                                <input type="text" class="form-control" name="nama_desa" 
                                       value="{{ old('nama_desa', $profil->nama_desa ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kepala Desa</label>
                                <input type="text" class="form-control" name="nama_kepala_desa" 
                                       value="{{ old('nama_kepala_desa', $profil->nama_kepala_desa ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Desa</label>
                            <textarea class="form-control" name="alamat_desa" rows="3" required>{{ old('alamat_desa', $profil->alamat_desa ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" 
                                       value="{{ old('kode_pos', $profil->kode_pos ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" name="telepon" 
                                       value="{{ old('telepon', $profil->telepon ?? '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                       value="{{ old('email', $profil->email ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Visi</label>
                            <textarea class="form-control" name="visi" rows="3">{{ old('visi', $profil->visi ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Misi</label>
                            <textarea class="form-control" name="misi" rows="4">{{ old('misi', $profil->misi ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sejarah</label>
                            <textarea class="form-control" name="sejarah" rows="5">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection