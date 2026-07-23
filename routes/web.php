<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SensorApiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;

// ===== AUTH =====
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== DASHBOARD =====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/toggle-pump', [DashboardController::class, 'togglePump'])->name('pump.toggle');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/export', [MonitoringController::class, 'export'])->name('monitoring.export');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/export', [HistoryController::class, 'export'])->name('history.export');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ===== API UNTUK ESP32 =====
Route::prefix('api/sensor')->group(function () {
    Route::post('/data',  [SensorApiController::class, 'store'])->name('api.sensor.store');
    Route::get('/latest', [SensorApiController::class, 'latest'])->name('api.sensor.latest');
});