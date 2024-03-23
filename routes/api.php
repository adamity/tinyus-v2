<?php

use App\Http\Controllers\API\ShortenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    // Shorten URL(s) route
    Route::post('/shorten', [ShortenController::class, 'store']); // Public

    // Get all shortened URLs route
    Route::get('/shorten', [ShortenController::class, 'index']); // Admin only

    // Get a shortened URL & its clicks route
    Route::get('/shorten/{id}', [ShortenController::class, 'show']); // Admin only

    // Update a shortened URL route
    Route::put('/shorten/{id}', [ShortenController::class, 'update']); // Admin only

    // Delete a shortened URL route
    Route::delete('/shorten/{id}', [ShortenController::class, 'destroy']); // Admin only

    // Restore a shortened URL route
    Route::patch('/shorten/{id}', [ShortenController::class, 'restore']); // Admin only

    // Get a statistics of a shortened URL route
    Route::get('/stats/{hash}', [ShortenController::class, 'stats']); // Public
});