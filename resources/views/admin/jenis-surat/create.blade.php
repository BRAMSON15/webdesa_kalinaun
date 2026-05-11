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
                <h1>Tambah Jenis Surat</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus"></i> Form Tambah Jenis Surat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jenis-surat.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_surat') is-invalid @enderror" 
                                   name="nama_surat" value="{{ old('nama_surat') }}" required
                                   placeholder="Contoh: Surat Keterangan Domisili">
                            @error('nama_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="4" 
                                      placeholder="Deskripsi singkat tentang jenis surat ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Persyaratan</label>
                            <div id="persyaratan-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="persyaratan[]" 
                                           placeholder="Contoh: Fotokopi KTP">
                                    <button type="button" class="btn btn-success" onclick="addPersyaratan()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">Tambahkan persyaratan yang diperlukan untuk surat ini</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan jenis surat ini
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Jenis Surat
                            </button>
                            <a href="{{ route('admin.jenis-surat') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
function addPersyaratan() {
    const container = document.getElementById('persyaratan-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="persyaratan[]" placeholder="Persyaratan lainnya">
        <button type="button" class="btn btn-danger" onclick="removePersyaratan(this)">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(div);
}

function removePersyaratan(button) {
    button.parentElement.remove();
}
</script>
@endsection