<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BlacklistApiController;
use App\Http\Controllers\Api\KafeApiController;
use App\Http\Controllers\Api\RekomendasiApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/kafe/search', [KafeApiController::class, 'search']);
Route::get('/kafe/{id}', [KafeApiController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/rekomendasi', [RekomendasiApiController::class, 'index']);
    Route::post('/kafe/{id}/blacklist', [BlacklistApiController::class, 'toggle']);
});
