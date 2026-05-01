<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WelcomeController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// USER ROUTES (Public)
// =========================================================================
Route::name('user.')->group(function () {
    Route::get('/', fn() => view('welcome'))->name('home');
    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    Route::prefix('cafe')->name('cafe.')->controller(CafeController::class)->group(function () {
        Route::get('/explore', 'index')->name('index');
        Route::get('/search-api', 'searchApi')->name('search.api');
        Route::get('/{id}', 'show')->name('detail');
    });

    // TODO: Tambah route rekomendasi, pencarian, preferensi di sini
    Route::get('/kafe/rekomendasi', [WelcomeController::class, 'cariRekomendasi'])->name('kafe.rekomendasi');
});


// ADMIN ROUTES
// Middleware auth + role admin ditambahkan di sini nanti:
// Route::middleware(['auth', 'role:admin'])->prefix('admin')-> ...
// =========================================================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
