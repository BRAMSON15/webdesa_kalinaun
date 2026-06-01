<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Kades\KadesController;
use App\Http\Controllers\Masyarakat\MasyarakatController;



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
    Route::delete('/data-pengguna/{id}', [AdminController::class, 'deletePengguna'])->name('data-pengguna.delete');
    Route::post('/data-pengguna/{id}/reset-password', [AdminController::class, 'resetPasswordPengguna'])->name('data-pengguna.reset-password');
    
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
    Route::resource('bansos', \App\Http\Controllers\Admin\BansosController::class)->parameters([
        'bansos' => 'bansos'
    ]);
    Route::post('/bansos/{bansos}/penerima/{penerima}/approve', [\App\Http\Controllers\Admin\BansosController::class, 'approvePenerima'])->name('bansos.approve-penerima');
    Route::post('/bansos/{bansos}/penerima/{penerima}/reject', [\App\Http\Controllers\Admin\BansosController::class, 'rejectPenerima'])->name('bansos.reject-penerima');
    Route::get('/bansos/{bansos}/penerima', [\App\Http\Controllers\Admin\BansosController::class, 'managePenerima'])->name('bansos.manage-penerima');
    Route::get('/bansos/penerima/{penerima}/whatsapp-approved', [\App\Http\Controllers\Admin\BansosController::class, 'getWhatsAppLinkApproved'])->name('bansos.whatsapp-approved');
    Route::get('/bansos/penerima/{penerima}/whatsapp-rejected', [\App\Http\Controllers\Admin\BansosController::class, 'getWhatsAppLinkRejected'])->name('bansos.whatsapp-rejected');
    
    // Tanda Tangan Elektronik
    Route::resource('tanda-tangan', \App\Http\Controllers\Admin\TandaTanganController::class);
    Route::post('/tanda-tangan/{tandaTangan}/toggle', [\App\Http\Controllers\Admin\TandaTanganController::class, 'toggleActive'])->name('tanda-tangan.toggle');
    
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
    
    // Validasi Pengajuan Surat
    Route::get('/validasi-pengajuan', [KadesController::class, 'validasiPengajuan'])->name('validasi-pengajuan');
    Route::get('/pengajuan/{id}', [KadesController::class, 'detailPengajuan'])->name('detail-pengajuan');
    Route::put('/pengajuan/{id}/proses', [KadesController::class, 'prosesPengajuan'])->name('proses-pengajuan');
    
    // Validasi Bansos
    Route::get('/validasi-bansos', [KadesController::class, 'validasiBansos'])->name('validasi-bansos');
    Route::post('/bansos/{bansos}/penerima/{penerima}/approve', [KadesController::class, 'approveBansos'])->name('bansos.approve-penerima');
    Route::post('/bansos/{bansos}/penerima/{penerima}/reject', [KadesController::class, 'rejectBansos'])->name('bansos.reject-penerima');
    
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

