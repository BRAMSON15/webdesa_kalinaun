@extends('layouts.sipakal')

@section('title', 'Detail Pengajuan Surat')

@section('body')
<link rel="stylesheet" href="{{ asset('css/dashboardkades.css') }}">

<div class="wrapper" style="height: auto; min-height: 100%;">

    @include('Kades.partials.header')

    @include('Kades.partials.sidebar')

    <div class="dashboard-main">
        <section class="dashboard-header">
            <h1>
                Detail Pengajuan Surat
                <small>Informasi lengkap pengajuan</small>
            </h1>
        </section>

        <section class="dashboard-content">
            <div style="display: flex; flex-wrap: wrap; margin: -10px;">
                <div style="width: 66.666%; padding: 10px; min-width: 300px;">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fas fa-file-alt"></i> Informasi Pengajuan</h3>
                        </div>
                        <div class="box-body">
                            <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
                                <div style="width: 50%; padding-right: 10px;">
                                    <strong>Jenis Surat:</strong><br>
                                    {{ $pengajuan->jenisSurat->nama_surat }}
                                </div>
                                <div style="width: 50%;">
                                    <strong>Tanggal Pengajuan:</strong><br>
                                    {{ $pengajuan->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
                                <div style="width: 50%; padding-right: 10px;">
                                    <strong>Status:</strong><br>
                                    @if($pengajuan->status == 'diproses')
                                        <span class="badge bg-warning" style="padding: 5px 10px;">Menunggu Validasi</span>
                                    @elseif($pengajuan->status == 'disetujui')
                                        <span class="badge bg-success" style="padding: 5px 10px;">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger" style="padding: 5px 10px;">Ditolak</span>
                                    @endif
                                </div>
                                <div style="width: 50%;">
                                    @if($pengajuan->nomor_surat)
                                    <strong>Nomor Surat:</strong><br>
                                    {{ $pengajuan->nomor_surat }}
                                    @endif
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <strong>Keperluan:</strong><br>
                                <p style="margin-top: 10px;">{{ $pengajuan->keperluan }}</p>
                            </div>

                            @if($pengajuan->catatan_kades)
                            <div style="margin-bottom: 15px;">
                                <strong>Catatan Kepala Desa:</strong><br>
                                <p style="margin-top: 10px;">{{ $pengajuan->catatan_kades }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="box" style="margin-top: 20px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fas fa-user"></i> Data Pemohon</h3>
                        </div>
                        <div class="box-body">
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="width: 50%; padding-right: 10px; margin-bottom: 15px;">
                                    <strong>Nama Lengkap:</strong><br>
                                    {{ $pengajuan->user->name }}
                                </div>
                                <div style="width: 50%; margin-bottom: 15px;">
                                    <strong>NIK:</strong><br>
                                    {{ $pengajuan->user->nik }}
                                </div>
                            </div>
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="width: 50%; padding-right: 10px; margin-bottom: 15px;">
                                    <strong>Email:</strong><br>
                                    {{ $pengajuan->user->email }}
                                </div>
                                <div style="width: 50%; margin-bottom: 15px;">
                                    <strong>No. HP:</strong><br>
                                    {{ $pengajuan->user->no_hp }}
                                </div>
                            </div>
                            <div>
                                <strong>Alamat:</strong><br>
                                {{ $pengajuan->user->alamat }}
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width: 33.333%; padding: 10px; min-width: 300px;">
                    @if($pengajuan->status == 'diproses')
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fas fa-check-circle"></i> Validasi Pengajuan</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" action="{{ route('kades.proses-pengajuan', $pengajuan->id) }}">
                                @csrf
                                @method('PUT')

                                <div style="margin-bottom: 15px;">
                                    <label for="status" style="display: block; margin-bottom: 5px; font-weight: 600;">
                                        Keputusan <span style="color: #dc3545;">*</span>
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required 
                                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                        <option value="">Pilih Keputusan</option>
                                        <option value="disetujui">Setujui</option>
                                        <option value="ditolak">Tolak</option>
                                    </select>
                                    @error('status')
                                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div style="margin-bottom: 15px;">
                                    <label for="catatan_kades" style="display: block; margin-bottom: 5px; font-weight: 600;">Catatan</label>
                                    <textarea class="form-control @error('catatan_kades') is-invalid @enderror" 
                                              id="catatan_kades" name="catatan_kades" rows="4" 
                                              placeholder="Berikan catatan jika diperlukan..."
                                              style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('catatan_kades') }}</textarea>
                                    @error('catatan_kades')
                                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    <i class="fas fa-check"></i> Proses Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="box" style="margin-top: 20px;">
                        <div class="box-body" style="text-align: center;">
                            <a href="{{ route('kades.validasi-pengajuan') }}" class="btn btn-secondary" style="width: 100%;">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('Kades.partials.scripts')
@endsection
