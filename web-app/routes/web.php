<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\User\CafeController as UserCafeController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CafeController as AdminCafeController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PerhitunganSAWController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KafeGambarBatchController;

// auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// user
Route::name('user.')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    Route::prefix('explore')->name('explore.')->controller(UserCafeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search-api', 'searchApi')->name('search.api');
        Route::get('/{id}', 'show')->name('detail');
    });

    Route::get('/kafe/rekomendasi', [WelcomeController::class, 'cariRekomendasi'])->name('kafe.rekomendasi');
    Route::view('/about', 'user.about_us.index')->name('about');
});

// admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // cafe
    Route::get('cafe/template', [AdminCafeController::class, 'downloadTemplate'])->name('cafe.template');
    Route::post('cafe/import', [AdminCafeController::class, 'import'])->name('cafe.import');
    Route::resource('cafe', AdminCafeController::class);
    Route::delete('cafe/image/{id}', [AdminCafeController::class, 'deleteImage'])->name('cafe.image.destroy');
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('fasilitas', FasilitasController::class);
    Route::resource('menu', MenuController::class);
    
    // batch upload gambar kafe
    Route::get('/galeri/batch', [KafeGambarBatchController::class, 'index'])->name('galeri.batch');
    Route::post('/galeri/batch', [KafeGambarBatchController::class, 'upload'])->name('galeri.batch.store');

    // saw
    Route::get('/perhitungan-saw', [PerhitunganSAWController::class, 'index'])->name('saw.index');
    Route::get('/perhitungan-saw/export-pdf', [PerhitunganSAWController::class, 'exportPdf'])->name('saw.export');

    // laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [LaporanController::class, 'printPdf'])->name('laporan.print');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
});
