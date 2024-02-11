<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\ShortenController::class, 'index'])->name('home'); // Public

Route::get('/stats', [App\Http\Controllers\ShortenController::class, 'stats'])->name('stats'); // Public

Route::get('/{hash}', [App\Http\Controllers\ShortenController::class, 'show']); // Public
