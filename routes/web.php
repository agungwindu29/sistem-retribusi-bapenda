<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\AuditController;
use App\Http\Middleware\EnsureIsAdmin;

// Public Guest Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Overview
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Upload PDF & Preview Validation
    Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');
    Route::post('/upload/process', [UploadController::class, 'process'])->name('upload.process');
    Route::post('/upload/save', [UploadController::class, 'save'])->name('upload.save');

    // Data Realisasi, Edit, Export Excel & Print
    Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi.index');
    Route::put('/realisasi/{id}', [RealisasiController::class, 'update'])->name('realisasi.update');
    Route::get('/realisasi/export', [RealisasiController::class, 'exportExcel'])->name('realisasi.export');
    Route::get('/realisasi/print', [RealisasiController::class, 'printReport'])->name('realisasi.print');
    Route::delete('/realisasi/{id}', [RealisasiController::class, 'destroy'])->name('realisasi.destroy');

    // Audit Log Trail (Strictly Admin Only)
    Route::get('/audit', [AuditController::class, 'index'])->middleware(EnsureIsAdmin::class)->name('audit.index');
});
