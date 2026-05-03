<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NormalisasiController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\Admin\PerhitunganSAWController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::name('user.')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    Route::prefix('cafe')->name('cafe.')->controller(CafeController::class)->group(function () {
        Route::get('/explore', 'index')->name('index');
        Route::get('/search-api', 'searchApi')->name('search.api');
        Route::get('/{id}', 'show')->name('detail');
    });

    Route::get('/kafe/rekomendasi', [WelcomeController::class, 'cariRekomendasi'])->name('kafe.rekomendasi');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cafe', \App\Http\Controllers\Admin\CafeController::class);

    // Frontend only (dummy)
    Route::get('/kriteria', function () {
        return view('admin.kriteria.index');
    })->name('kriteria.index');

    Route::get('/matriks-keputusan', function () {
    return view('admin.matriks-keputusan.index');
})->name('matriks-keputusan.index');

    Route::get('/normalisasi', [NormalisasiController::class, 'index'])->name('normalisasi.index');
    Route::get('/perhitungan-saw', [PerhitunganSAWController::class, 'index'])
        ->name('saw.index');
    
    Route::view('/signin', 'admin.auth.signin')->name('signin');
    Route::view('/signup', 'admin.auth.signup')->name('signup');
});