<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get(
    '/',
    fn() => Inertia::render('home')
)->name('home');

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