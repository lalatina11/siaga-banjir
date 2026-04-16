<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FloodController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get(
    '/',
    [FloodController::class, 'index']
)->name('home');

Route::get('/flood/{id}', [FloodController::class, 'show'])->name('single-flood');

Route::middleware(['guest.middleware'])->group(function () {
    Route::get('/auth', [AuthController::class, 'showAuthPage'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth.middleware'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('/admin')->middleware(['admin.middleware']);
Route::prefix('/superadmin')->middleware(['super.admin.middleware']);

Route::get('/flood', fn() => Inertia::render('single-flood'));