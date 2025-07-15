<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DashboardEquipmentController;
use App\Http\Controllers\Dashboard\DashboardInspectionController;
use App\Http\Controllers\Dashboard\DashboardUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Default URL
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen User
    Route::get('/dashboard/pengguna', [DashboardUserController::class, 'index'])->name('dashboard.user.index');
    Route::get('/dashboard/pengguna/tambah', [DashboardUserController::class, 'create'])->name('dashboard.user.create');
    Route::post('/dashboard/pengguna/tambah', [DashboardUserController::class, 'store'])->name('dashboard.user.store');
    Route::get('/dashboard/pengguna/{id}/ubah', [DashboardUserController::class, 'edit'])->name('dashboard.user.edit');
    Route::put('/dashboard/pengguna/{id}/ubah', [DashboardUserController::class, 'update'])->name('dashboard.user.update');
    Route::delete('/dashboard/pengguna/{id}/hapus', [DashboardUserController::class, 'destroy'])->name('dashboard.user.destroy');

    // Manajemen Alat Berat
    Route::get('/dashboard/alat-berat', [DashboardEquipmentController::class, 'index'])->name('dashboard.equipment.index');
    Route::get('/dashboard/alat-berat/tambah', [DashboardEquipmentController::class, 'create'])->name('dashboard.equipment.create');
    Route::post('/dashboard/alat-berat/tambah', [DashboardEquipmentController::class, 'store'])->name('dashboard.equipment.store');
    Route::get('/dashboard/alat-berat/{id}/ubah', [DashboardEquipmentController::class, 'edit'])->name('dashboard.equipment.edit');
    Route::put('/dashboard/alat-berat/{id}/ubah', [DashboardEquipmentController::class, 'update'])->name('dashboard.equipment.update');
    Route::delete('/dashboard/alat-berat/{id}/hapus', [DashboardEquipmentController::class, 'destroy'])->name('dashboard.equipment.destroy');

    // Manajemen Inspeksi
    Route::get('/dashboard/inspeksi', [DashboardInspectionController::class, 'index'])->name('dashboard.inspection.index');
    Route::get('/dashboard/inspeksi/tambah', [DashboardInspectionController::class, 'create'])->name('dashboard.inspection.create');
    Route::post('/dashboard/inspeksi/tambah', [DashboardInspectionController::class, 'store'])->name('dashboard.inspection.store');
    Route::get('/dashboard/inspeksi/{id}/lihat', [DashboardInspectionController::class, 'show'])->name('dashboard.inspection.show');
    Route::delete('/dashboard/inspeksi/{id}/hapus', [DashboardInspectionController::class, 'destroy'])->name('dashboard.inspection.destroy');
});
