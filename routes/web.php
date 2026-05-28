<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Kades\KadesController;
use App\Http\Controllers\Masyarakat\MasyarakatController;

// Class Diagram Controllers
use App\Http\Controllers\ClassDiagramAuthController;
use App\Http\Controllers\ClassDiagram\MasyarakatController as ClassDiagramMasyarakatController;
use App\Http\Controllers\ClassDiagram\SekdesController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetToken'])->name('forgot-password.send');
Route::get('/reset-password/{token}/{email}', [AuthController::class, 'showResetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('reset-password.update');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Profil Desa
    Route::get('/profil-desa', [AdminController::class, 'profilDesa'])->name('profil-desa');
    Route::put('/profil-desa', [AdminController::class, 'updateProfilDesa'])->name('profil-desa.update');
    
    // Pengajuan Surat
    Route::get('/pengajuan-surat', [AdminController::class, 'pengajuanSurat'])->name('pengajuan-surat');
    Route::get('/cetak-surat/{id}', [AdminController::class, 'cetakSurat'])->name('cetak-surat');
    
    // Informasi Desa
    Route::get('/informasi-desa', [AdminController::class, 'informasiDesa'])->name('informasi-desa');
    Route::get('/informasi-desa/create', [AdminController::class, 'createInformasi'])->name('informasi-desa.create');
    Route::post('/informasi-desa', [AdminController::class, 'storeInformasi'])->name('informasi-desa.store');
    Route::get('/informasi-desa/{id}', [AdminController::class, 'showInformasi'])->name('informasi-desa.show');
    Route::get('/informasi-desa/{id}/edit', [AdminController::class, 'editInformasi'])->name('informasi-desa.edit');
    Route::put('/informasi-desa/{id}', [AdminController::class, 'updateInformasi'])->name('informasi-desa.update');
    Route::delete('/informasi-desa/{id}', [AdminController::class, 'destroyInformasi'])->name('informasi-desa.destroy');
    
    // Data Pengguna
    Route::get('/data-pengguna', [AdminController::class, 'dataPengguna'])->name('data-pengguna');
    Route::put('/data-pengguna/{id}', [AdminController::class, 'updatePengguna'])->name('data-pengguna.update');
    
    // Jenis Surat
    Route::get('/jenis-surat', [AdminController::class, 'jenisSurat'])->name('jenis-surat');
    Route::get('/jenis-surat/create', [AdminController::class, 'createJenisSurat'])->name('jenis-surat.create');
    Route::post('/jenis-surat', [AdminController::class, 'storeJenisSurat'])->name('jenis-surat.store');
    Route::get('/jenis-surat/{id}', [AdminController::class, 'showJenisSurat'])->name('jenis-surat.show');
    Route::get('/jenis-surat/{id}/edit', [AdminController::class, 'editJenisSurat'])->name('jenis-surat.edit');
    Route::put('/jenis-surat/{id}', [AdminController::class, 'updateJenisSurat'])->name('jenis-surat.update');
    Route::delete('/jenis-surat/{id}', [AdminController::class, 'destroyJenisSurat'])->name('jenis-surat.destroy');
    
    // Arsip Dokumen
    Route::get('/arsip-dokumen', [AdminController::class, 'arsipDokumen'])->name('arsip-dokumen');
    Route::get('/arsip-dokumen/create', [AdminController::class, 'createArsip'])->name('arsip-dokumen.create');
    Route::post('/arsip-dokumen', [AdminController::class, 'storeArsip'])->name('arsip-dokumen.store');
    
    // Pengaduan Masyarakat
    Route::resource('pengaduan', \App\Http\Controllers\Admin\PengaduanController::class);
    
    // Bansos Management
    Route::resource('bansos', \App\Http\Controllers\Admin\BansosController::class);
    Route::post('/bansos/{bansos}/penerima/{penerima}/approve', [\App\Http\Controllers\Admin\BansosController::class, 'approvePenerima'])->name('bansos.approve-penerima');
    Route::post('/bansos/{bansos}/penerima/{penerima}/reject', [\App\Http\Controllers\Admin\BansosController::class, 'rejectPenerima'])->name('bansos.reject-penerima');
    Route::get('/bansos/{bansos}/penerima', [\App\Http\Controllers\Admin\BansosController::class, 'managePenerima'])->name('bansos.manage-penerima');
    
    // Export
    Route::get('/export/pengaduan', [\App\Http\Controllers\ExportController::class, 'exportPengaduan'])->name('export.pengaduan');
    Route::get('/export/bansos', [\App\Http\Controllers\ExportController::class, 'exportBansos'])->name('export.bansos');
    Route::get('/export/penerima-bansos', [\App\Http\Controllers\ExportController::class, 'exportPenerimaBansos'])->name('export.penerima-bansos');
    Route::get('/export/pengajuan-surat', [\App\Http\Controllers\ExportController::class, 'exportPengajuanSurat'])->name('export.pengajuan-surat');
    
    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics');
});

// Kades Routes
Route::middleware(['auth', 'role:kades'])->prefix('kades')->name('kades.')->group(function () {
    Route::get('/dashboard', [KadesController::class, 'dashboard'])->name('dashboard');
    
    // Profil Sekdes
    Route::get('/profil', [KadesController::class, 'profilSekdes'])->name('profil');
    Route::put('/profil', [KadesController::class, 'updateProfil'])->name('profil.update');
    
    // Validasi Pengajuan
    Route::get('/validasi-pengajuan', [KadesController::class, 'validasiPengajuan'])->name('validasi-pengajuan');
    Route::get('/pengajuan/{id}', [KadesController::class, 'detailPengajuan'])->name('detail-pengajuan');
    Route::put('/pengajuan/{id}/proses', [KadesController::class, 'prosesPengajuan'])->name('proses-pengajuan');
    
    // Monitoring
    Route::get('/monitoring-pengaduan', [KadesController::class, 'monitoringPengaduan'])->name('monitoring-pengaduan');
    
    // Laporan Arsip
    Route::get('/laporan-arsip', [KadesController::class, 'laporanArsip'])->name('laporan-arsip');
});

// Masyarakat Routes
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/dashboard', [MasyarakatController::class, 'dashboard'])->name('dashboard');
    
    // Pengajuan Surat
    Route::get('/pengajuan-surat', [MasyarakatController::class, 'pengajuanSurat'])->name('pengajuan-surat');
    Route::get('/pengajuan-surat/create/{jenisSuratId}', [MasyarakatController::class, 'createPengajuan'])->name('pengajuan-surat.create');
    Route::post('/pengajuan-surat', [MasyarakatController::class, 'storePengajuan'])->name('pengajuan-surat.store');
    
    // Riwayat Pengajuan
    Route::get('/riwayat-pengajuan', [MasyarakatController::class, 'riwayatPengajuan'])->name('riwayat-pengajuan');
    Route::get('/pengajuan/{id}/detail', [MasyarakatController::class, 'detailPengajuan'])->name('detail-pengajuan');
    Route::get('/pengajuan/{id}/download', [MasyarakatController::class, 'downloadSurat'])->name('download-surat');
    
    // Informasi Desa
    Route::get('/informasi-desa', [MasyarakatController::class, 'informasiDesa'])->name('informasi-desa');
    Route::get('/informasi-desa/{id}', [MasyarakatController::class, 'detailInformasi'])->name('detail-informasi');
    
    // Profil Desa
    Route::get('/profil-desa', [MasyarakatController::class, 'profilDesa'])->name('profil-desa');
    
    // Profil User
    Route::get('/profil', [MasyarakatController::class, 'profil'])->name('profil');
    Route::put('/profil', [MasyarakatController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/update-password', [MasyarakatController::class, 'updatePassword'])->name('profil.update-password');
    
    // Pengaduan Masyarakat
    Route::resource('pengaduan', \App\Http\Controllers\Masyarakat\PengaduanController::class);
    
    // Bansos
    Route::get('/bansos', [\App\Http\Controllers\Masyarakat\BansosController::class, 'index'])->name('bansos.index');
    Route::get('/bansos/{bansos}', [\App\Http\Controllers\Masyarakat\BansosController::class, 'show'])->name('bansos.show');
    Route::post('/bansos/{bansos}/apply', [\App\Http\Controllers\Masyarakat\BansosController::class, 'apply'])->name('bansos.apply');
    Route::get('/bansos-applications', [\App\Http\Controllers\Masyarakat\BansosController::class, 'myApplications'])->name('bansos.applications');
    Route::get('/bansos-applications/{penerima}', [\App\Http\Controllers\Masyarakat\BansosController::class, 'applicationDetail'])->name('bansos.application-detail');
    Route::delete('/bansos-applications/{penerima}', [\App\Http\Controllers\Masyarakat\BansosController::class, 'cancelApplication'])->name('bansos.cancel-application');
    
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [\App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
});

// ========================================
// CLASS DIAGRAM ROUTES (Sesuai Diagram)
// ========================================

// Class Diagram Authentication Routes
Route::prefix('class-diagram')->name('class-diagram.')->group(function () {
    Route::get('/login', [ClassDiagramAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [ClassDiagramAuthController::class, 'login']);
    Route::get('/register', [ClassDiagramAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [ClassDiagramAuthController::class, 'register']);
    Route::post('/logout', [ClassDiagramAuthController::class, 'logout'])->name('logout');

    // Masyarakat Routes (Class Diagram)
    Route::middleware(['auth:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
        Route::get('/dashboard', [ClassDiagramMasyarakatController::class, 'dashboard'])->name('dashboard');
        Route::get('/form-pengajuan', [ClassDiagramMasyarakatController::class, 'formPengajuan'])->name('form-pengajuan');
        Route::post('/buat-pengajuan', [ClassDiagramMasyarakatController::class, 'buatPengajuan'])->name('buat-pengajuan');
        Route::get('/riwayat-pengajuan', [ClassDiagramMasyarakatController::class, 'riwayatPengajuan'])->name('riwayat-pengajuan');
        Route::get('/cek-status/{id}', [ClassDiagramMasyarakatController::class, 'cekStatus'])->name('cek-status');
        Route::get('/profil', [ClassDiagramMasyarakatController::class, 'profil'])->name('profil');
        Route::put('/profil', [ClassDiagramMasyarakatController::class, 'updateProfil'])->name('profil.update');
    });

    // Sekdes Routes (Class Diagram)
    Route::middleware(['auth:sekdes'])->prefix('sekdes')->name('sekdes.')->group(function () {
        Route::get('/dashboard', [SekdesController::class, 'dashboard'])->name('dashboard');
        Route::get('/daftar-pengajuan', [SekdesController::class, 'daftarPengajuan'])->name('daftar-pengajuan');
        Route::get('/detail-pengajuan/{id}', [SekdesController::class, 'detailPengajuan'])->name('detail-pengajuan');
        Route::post('/validasi-akhir/{id}', [SekdesController::class, 'validasiAkhir'])->name('validasi-akhir');
        Route::get('/laporan-arsip', [SekdesController::class, 'laporanArsip'])->name('laporan-arsip');
        Route::get('/export-laporan', [SekdesController::class, 'exportLaporan'])->name('export-laporan');
        Route::get('/profil', [SekdesController::class, 'profil'])->name('profil');
        Route::put('/profil', [SekdesController::class, 'updateProfil'])->name('profil.update');
    });
});
