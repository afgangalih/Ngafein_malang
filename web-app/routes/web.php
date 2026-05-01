<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\Admin\DashboardController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::name('user.')->group(function () {
    Route::get('/', fn() => view('welcome'))->name('home');

    Route::prefix('cafe')->name('cafe.')->controller(CafeController::class)->group(function () {
        Route::get('/explore', 'index')->name('index');
        Route::get('/search-api', 'searchApi')->name('search.api');
        Route::get('/{id}', 'show')->name('detail');
    });
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
