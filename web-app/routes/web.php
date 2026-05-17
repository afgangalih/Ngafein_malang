<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\Admin\PerhitunganSAWController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::name('user.')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    Route::prefix('explore')->name('explore.')->controller(CafeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search-api', 'searchApi')->name('search.api');
        Route::get('/{id}', 'show')->name('detail');
    });

    Route::get('/kafe/rekomendasi', [WelcomeController::class, 'cariRekomendasi'])->name('kafe.rekomendasi');
    Route::view('/about', 'user.about_us.index') ->name('about');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // cafe
    Route::get('cafe/template', [\App\Http\Controllers\Admin\CafeController::class, 'downloadTemplate'])->name('cafe.template');
    Route::post('cafe/import', [\App\Http\Controllers\Admin\CafeController::class, 'import'])->name('cafe.import');
    Route::resource('cafe', \App\Http\Controllers\Admin\CafeController::class);
    Route::delete('cafe/image/{id}', [\App\Http\Controllers\Admin\CafeController::class, 'deleteImage'])->name('cafe.image.destroy');

    // kriteria
    Route::resource('kriteria', \App\Http\Controllers\Admin\KriteriaController::class);

    Route::get('/perhitungan-saw', [PerhitunganSAWController::class, 'index'])
        ->name('saw.index');

    Route::get('/perhitungan-saw/export-pdf', [PerhitunganSAWController::class, 'exportPdf'])
        ->name('saw.export');
    
    Route::view('/signin', 'admin.auth.signin')->name('signin');
    Route::view('/signup', 'admin.auth.signup')->name('signup');
});