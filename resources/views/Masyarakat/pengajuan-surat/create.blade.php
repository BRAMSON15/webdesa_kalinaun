@extends('layouts.app')

@section('title', 'Form Pengajuan Surat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Form Pengajuan: {{ $jenisSurat->nama_surat }}</h2>
            <p class="text-muted">{{ $jenisSurat->deskripsi }}</p>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('masyarakat.pengajuan-surat.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                                      id="keperluan" name="keperluan" rows="4" required 
                                      placeholder="Jelaskan keperluan pengajuan surat ini...">{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Data Tambahan -->
                        <div class="mb-3">
                            <h5>Data Tambahan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap" 
                                               name="data_formulir[nama_lengkap]" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" 
                                               name="data_formulir[nik]" value="{{ auth()->user()->nik }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="data_formulir[alamat]" 
                                          rows="2" readonly>{{ auth()->user()->alamat }}</textarea>
                            </div>
                            
                            <!-- Field tambahan berdasarkan jenis surat -->
                            @if(str_contains(strtolower($jenisSurat->nama_surat), 'usaha'))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                        <input type="text" class="form-control" id="nama_usaha" 
                                               name="data_formulir[nama_usaha]" value="{{ old('data_formulir.nama_usaha') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                        <input type="text" class="form-control" id="jenis_usaha" 
                                               name="data_formulir[jenis_usaha]" value="{{ old('data_formulir.jenis_usaha') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_usaha" class="form-label">Alamat Usaha</label>
                                <textarea class="form-control" id="alamat_usaha" name="data_formulir[alamat_usaha]" 
                                          rows="2">{{ old('data_formulir.alamat_usaha') }}</textarea>
                            </div>
                            @endif

                            @if(str_contains(strtolower($jenisSurat->nama_surat), 'nikah'))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_calon_pasangan" class="form-label">Nama Calon Pasangan</label>
                                        <input type="text" class="form-control" id="nama_calon_pasangan" 
                                               name="data_formulir[nama_calon_pasangan]" value="{{ old('data_formulir.nama_calon_pasangan') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_rencana_nikah" class="form-label">Tanggal Rencana Nikah</label>
                                        <input type="date" class="form-control" id="tanggal_rencana_nikah" 
                                               name="data_formulir[tanggal_rencana_nikah]" value="{{ old('data_formulir.tanggal_rencana_nikah') }}">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Upload Dokumen Pendukung -->
                        <div class="mb-3">
                            <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung</label>
                            <input type="file" class="form-control @error('dokumen_pendukung.*') is-invalid @enderror" 
                                   id="dokumen_pendukung" name="dokumen_pendukung[]" multiple 
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text">
                                Upload dokumen pendukung (PDF, JPG, PNG). Maksimal 2MB per file.
                            </div>
                            @error('dokumen_pendukung.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('masyarakat.pengajuan-surat') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informasi</h5>
                </div>
                <div class="card-body">
                    <h6>Jenis Surat:</h6>
                    <p>{{ $jenisSurat->nama_surat }}</p>

                    @if($jenisSurat->persyaratan)
                    <h6>Persyaratan:</h6>
                    <ul>
                        @foreach($jenisSurat->persyaratan as $syarat)
                        <li>{{ $syarat }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-clock"></i>
                            Pengajuan akan diproses dalam 1-3 hari kerja setelah dokumen lengkap.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection