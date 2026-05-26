@extends('layouts.masyarakat')

@section('title', 'Profil Akun - SIPAKAL')

@section('content')
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Profile Edit Card -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profil Akun</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('masyarakat.profil.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name', $user->name ?? auth()->user()->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email', $user->email ?? auth()->user()->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                                                       id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '') }}" required>
                                                @error('no_hp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="nik" class="form-label">NIK</label>
                                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                                       id="nik" name="nik" value="{{ old('nik', $user->nik ?? '') }}">
                                                @error('nik')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                                       id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir ?? '') }}">
                                                @error('tempat_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                                       id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ?? '') }}">
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                                        id="jenis_kelamin" name="jenis_kelamin">
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                                       id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $user->pekerjaan ?? '') }}">
                                                @error('pekerjaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                            <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Account Information Card -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Akun</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Role:</div>
                                        <div class="col-md-8">
                                            <span class="badge bg-success">Masyarakat</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Tanggal Registrasi:</div>
                                        <div class="col-md-8">{{ ($user->created_at ?? auth()->user()->created_at)->format('d F Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Terakhir Update:</div>
                                        <div class="col-md-8">{{ ($user->updated_at ?? auth()->user()->updated_at)->format('d F Y, H:i') }} WIB</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Status Akun:</div>
                                        <div class="col-md-8">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Change Password Card -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="fas fa-key"></i> Ubah Password</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('masyarakat.profil.update-password') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" name="current_password" required>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-key"></i> Ubah Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection