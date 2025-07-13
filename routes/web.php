<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
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
});
