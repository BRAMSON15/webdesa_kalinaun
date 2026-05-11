@extends('layouts.app')

@section('title', 'Login - Sistem Class Diagram')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login Sistem Class Diagram</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('class-diagram.login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="user_type" class="form-label">Tipe User</label>
                            <select class="form-select @error('user_type') is-invalid @enderror" 
                                    id="user_type" name="user_type" required>
                                <option value="">Pilih Tipe User</option>
                                <option value="masyarakat" {{ old('user_type') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                <option value="sekdes" {{ old('user_type') == 'sekdes' ? 'selected' : '' }}>Sekretaris Desa</option>
                                <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username/Email</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username') }}" required>
                            <div class="form-text">
                                <small>Masyarakat: gunakan email | Sekdes/Admin: gunakan username</small>
                            </div>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Belum punya akun masyarakat? <a href="{{ route('class-diagram.register') }}">Daftar di sini</a></p>
                    </div>

                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <strong>Akun Demo Class Diagram:</strong><br>
                            <strong>Masyarakat:</strong> ahmad.wijaya@gmail.com / password123<br>
                            <strong>Sekdes:</strong> sekdes_desa / sekdes123<br>
                            <strong>Admin:</strong> admin_desa / admin123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection