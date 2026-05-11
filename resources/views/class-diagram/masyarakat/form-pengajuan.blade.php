@extends('layouts.app')

@section('title', 'Form Pengajuan Surat - Class Diagram')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Form Pengajuan Surat</h2>
            <p class="text-muted">Isi form berikut untuk mengajukan surat keterangan</p>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('class-diagram.masyarakat.buat-pengajuan') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_surat') is-invalid @enderror" 
                                    id="jenis_surat" name="jenis_surat" required>
                                <option value="">Pilih Jenis Surat</option>
                                @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis }}" {{ old('jenis_surat') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan/Keperluan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="5" required 
                                      placeholder="Jelaskan keperluan pengajuan surat ini secara detail...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Pemohon (Read Only) -->
                        <div class="mb-3">
                            <h5>Data Pemohon</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" 
                                               value="{{ auth('masyarakat')->user()->nama }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" 
                                               value="{{ auth('masyarakat')->user()->nik }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" 
                                               value="{{ auth('masyarakat')->user()->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No. HP</label>
                                        <input type="text" class="form-control" id="no_hp" 
                                               value="{{ auth('masyarakat')->user()->no_hp }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('class-diagram.masyarakat.dashboard') }}" class="btn btn-secondary">
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
                    <h6>Jenis Surat yang Tersedia:</h6>
                    <ul>
                        @foreach($jenisSurat as $jenis)
                        <li>{{ $jenis }}</li>
                        @endforeach
                    </ul>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-clock"></i>
                            Pengajuan akan diproses dalam 1-3 hari kerja setelah disubmit.
                        </small>
                    </div>

                    <div class="alert alert-warning">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i>
                            Pastikan data yang Anda masukkan sudah benar sebelum mengirim pengajuan.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection