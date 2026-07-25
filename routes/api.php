<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\DashboardController;

// =====================================================
// API KHUSUS APP MOBILE FLUTTER (autentikasi Sanctum/Bearer token)
// Endpoint /api/sensor/data dan /api/sensor/latest yang dipakai ESP32
// TETAP di routes/web.php seperti sebelumnya — TIDAK dipindah ke sini,
// supaya tidak ada risiko mengganggu koneksi ESP32 yang sudah jalan.
// =====================================================

Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    // Reuse method togglePump() yang SAMA PERSIS dipakai dashboard web —
    // logic-nya (transaction, sync ke Setting, watering history) otomatis
    // ikut berlaku juga untuk mobile, tidak ada kode yang diduplikasi.
    Route::post('/pump/toggle', [DashboardController::class, 'togglePump'])->name('api.pump.toggle');
});