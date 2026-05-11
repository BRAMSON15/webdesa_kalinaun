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
                                        <i class="fas fa-plus-circle"></i> Buat Pengajuan Surat
                                    </h4>
                                    <p class="card-text">Pilih jenis surat yang ingin Anda ajukan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Letter Types -->
                    <div class="row">
                        @if($jenisSurats->count() > 0)
                            @foreach($jenisSurats as $jenis)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-file-alt text-primary"></i> 
                                                {{ $jenis->nama_surat }}
                                            </h5>
                                            <p class="card-text">{{ $jenis->deskripsi ?? 'Surat keterangan resmi dari desa' }}</p>
                                            
                                            @if($jenis->persyaratan)
                                                <div class="mb-3">
                                                    <strong>Persyaratan:</strong>
                                                    <ul class="mt-2">
                                                        @foreach($jenis->persyaratan as $syarat)
                                                            <li>{{ $syarat }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            
                                            <a href="{{ route('masyarakat.pengajuan-surat.create', $jenis->id) }}" 
                                               class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Ajukan Surat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default letter types if no data -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-home text-primary"></i> 
                                            Surat Keterangan Domisili
                                        </h5>
                                        <p class="card-text">Surat keterangan tempat tinggal</p>
                                        <div class="mb-3">
                                            <strong>Persyaratan:</strong>
                                            <ul class="mt-2">
                                                <li>KTP</li>
                                                <li>KK</li>
                                                <li>Surat Pengantar RT/RW</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-primary" onclick="alert('Silakan hubungi admin untuk mengaktifkan fitur ini')">
                                            <i class="fas fa-plus"></i> Ajukan Surat
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-user text-primary"></i> 
                                            Surat Keterangan Usaha
                                        </h5>
                                        <p class="card-text">Surat keterangan memiliki usaha</p>
                                        <div class="mb-3">
                                            <strong>Persyaratan:</strong>
                                            <ul class="mt-2">
                                                <li>KTP</li>
                                                <li>KK</li>
                                                <li>Foto Tempat Usaha</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-primary" onclick="alert('Silakan hubungi admin untuk mengaktifkan fitur ini')">
                                            <i class="fas fa-plus"></i> Ajukan Surat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($jenisSurats->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle"></i>
                                    Belum ada jenis surat yang tersedia. Silakan hubungi admin desa.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('Masyarakat.partials.scripts')
</body>
</html>