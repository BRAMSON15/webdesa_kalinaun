<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengaduanApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Routes for Pengaduan
Route::middleware('auth:sanctum')->prefix('pengaduan')->group(function () {
    Route::get('/', [PengaduanApiController::class, 'index']);
    Route::post('/', [PengaduanApiController::class, 'store']);
    Route::get('/{pengaduan}', [PengaduanApiController::class, 'show']);
    Route::put('/{pengaduan}', [PengaduanApiController::class, 'update']);
    Route::delete('/{pengaduan}', [PengaduanApiController::class, 'destroy']);
    Route::get('/statistics/all', [PengaduanApiController::class, 'statistics']);
});
