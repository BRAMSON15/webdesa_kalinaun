<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat - SIPAKAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardmasyarakat.css') }}">
</head>
<body>
    <div class="dashboard-container">
        @include('Masyarakat.partials.header')
        @include('Masyarakat.partials.sidebar')
        
        <div class="dashboard-main">
            <div class="dashboard-content">
                <div class="container-fluid mt-4">
                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-primary">
                                        <i class="fas fa-file-plus"></i> Pengajuan Surat
                                    </h4>
                                    <p class="card-text">Ajukan berbagai jenis surat keterangan yang Anda butuhkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <!-- Available Letter Types -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-list"></i> Jenis Surat Tersedia</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if(isset($jenisSurat) && $jenisSurat->count() > 0)
                                            @foreach($jenisSurat as $jenis)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card border-primary h-100">
                                                        <div class="card-body text-center">
                                                            <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                                                            <h6 class="card-title">{{ $jenis->nama_surat }}</h6>
                                                            <p class="card-text small text-muted">{{ $jenis->deskripsi ?? 'Surat keterangan resmi dari desa' }}</p>
                                                            <button type="button" class="btn btn-primary btn-sm" 
                                                                    onclick="selectJenisSurat({{ $jenis->id }}, '{{ $jenis->nama_surat }}')">
                                                                <i class="fas fa-plus"></i> Pilih
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default letter types if no data -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-primary h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-home fa-3x text-primary mb-3"></i>
                                                        <h6 class="card-title">Surat Keterangan Domisili</h6>
                                                        <p class="card-text small text-muted">Surat keterangan tempat tinggal</p>
                                                        <button type="button" class="btn btn-primary btn-sm" 
                                                                onclick="selectJenisSurat(1, 'Surat Keterangan Domisili')">
                                                            <i class="fas fa-plus"></i> Pilih
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-primary h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                                        <h6 class="card-title">Surat Keterangan Usaha</h6>
                                                        <p class="card-text small text-muted">Surat keterangan memiliki usaha</p>
                                                        <button type="button" class="btn btn-primary btn-sm" 
                                                                onclick="selectJenisSurat(2, 'Surat Keterangan Usaha')">
                                                            <i class="fas fa-plus"></i> Pilih
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card border-primary h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                                                        <h6 class="card-title">Surat Keterangan Belum Menikah</h6>
                                                        <p class="card-text small text-muted">Surat keterangan status belum menikah</p>
                                                        <button type="button" class="btn btn-primary btn-sm" 
                                                                onclick="selectJenisSurat(3, 'Surat Keterangan Belum Menikah')">
                                                            <i class="fas fa-plus"></i> Pilih
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pengajuan -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Pengajuan Surat</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('masyarakat.pengajuan-surat.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="jenis_surat_id" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                                <select name="jenis_surat_id" id="jenis_surat_id" class="form-select @error('jenis_surat_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Jenis Surat --</option>
                                                    @if(isset($jenisSurat))
                                                        @foreach($jenisSurat as $jenis)
                                                            <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                                                {{ $jenis->nama_surat }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="1">Surat Keterangan Domisili</option>
                                                        <option value="2">Surat Keterangan Usaha</option>
                                                        <option value="3">Surat Keterangan Belum Menikah</option>
                                                    @endif
                                                </select>
                                                @error('jenis_surat_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('keperluan') is-invalid @enderror" 
                                                       id="keperluan" name="keperluan" value="{{ old('keperluan') }}" 
                                                       placeholder="Contoh: Untuk melamar pekerjaan" required>
                                                @error('keperluan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                                      rows="3" placeholder="Jelaskan detail tambahan jika diperlukan...">{{ old('keterangan') }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="dokumen" class="form-label">Dokumen Pendukung</label>
                                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror" 
                                                       id="dokumen" name="dokumen" accept=".jpg,.jpeg,.png,.pdf">
                                                <div class="form-text">Format: JPG, PNG, PDF. Maksimal 2MB</div>
                                                @error('dokumen')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_diperlukan" class="form-label">Tanggal Diperlukan</label>
                                                <input type="date" class="form-control @error('tanggal_diperlukan') is-invalid @enderror" 
                                                       id="tanggal_diperlukan" name="tanggal_diperlukan" 
                                                       value="{{ old('tanggal_diperlukan') }}" min="{{ date('Y-m-d') }}">
                                                <div class="form-text">Kosongkan jika tidak ada batas waktu khusus</div>
                                                @error('tanggal_diperlukan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Persyaratan -->
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle"></i> Persyaratan Umum:</h6>
                                            <ul class="mb-0">
                                                <li>Fotokopi KTP yang masih berlaku</li>
                                                <li>Fotokopi Kartu Keluarga</li>
                                                <li>Dokumen pendukung sesuai jenis surat yang diminta</li>
                                                <li>Mengisi formulir dengan data yang benar dan lengkap</li>
                                            </ul>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary me-md-2">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('Masyarakat.partials.scripts')
    
    <script>
        function selectJenisSurat(id, nama) {
            document.getElementById('jenis_surat_id').value = id;
            
            // Update keperluan placeholder based on letter type
            const keperluanInput = document.getElementById('keperluan');
            if (nama.includes('Domisili')) {
                keperluanInput.placeholder = 'Contoh: Untuk melamar pekerjaan';
            } else if (nama.includes('Usaha')) {
                keperluanInput.placeholder = 'Contoh: Untuk mengurus izin usaha';
            } else if (nama.includes('Belum Menikah')) {
                keperluanInput.placeholder = 'Contoh: Untuk persyaratan menikah';
            }
            
            // Scroll to form
            document.querySelector('.card-header.bg-success').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }
    </script>
</body>
</html>