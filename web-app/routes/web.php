<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WelcomeController;


// USER ROUTES (Public)
// =========================================================================
Route::name('user.')->group(function () {

    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    Route::prefix('cafe')->name('cafe.')->group(function () {
        Route::get('/explore', [CafeController::class, 'index'])->name('index');
        Route::get('/search-api', [CafeController::class, 'searchApi'])->name('search.api');
        Route::get('/{id}', [CafeController::class, 'show'])->name('detail');
    });

    // TODO: Tambah route rekomendasi, pencarian, preferensi di sini
    Route::get('/kafe/rekomendasi', [WelcomeController::class, 'cariRekomendasi'])->name('kafe.rekomendasi');
});


// ADMIN ROUTES
// Middleware auth + role admin ditambahkan di sini nanti:
// Route::middleware(['auth', 'role:admin'])->prefix('admin')-> ...
// =========================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // TODO: Tambah route kelola kafe, menu, fasilitas, user di sini
});
