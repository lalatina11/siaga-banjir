<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FloodController;
use App\Http\Controllers\UserDashboardController;
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
    Route::get('/new-flood', [FloodController::class, 'newFloodPage']);
    Route::prefix('/profile')->group(function () {

        Route::get('/', [AuthController::class, 'showProfilePage']);
        Route::get('/update-password', [AuthController::class, 'showUpdatePassword']);
    });
    Route::prefix('/dashboard')->group(function () {
        Route::middleware('user.middleware')->group(function () {
            Route::get('/', [UserDashboardController::class, 'index']);
        });
        Route::prefix('/admin')->middleware('admin.middleware')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index']);
        });
    });
    Route::prefix('/api')->group(function () {
        Route::prefix('/flood')->group(function () {
            Route::post('/create', [FloodController::class, 'store']);
            Route::post('/accept/{id}', [FloodController::class, 'accept'])->middleware('dual-admin.middleware');
        });
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);
        Route::post('/update-password', [AuthController::class, 'updatePassword']);
    })->middleware('auth.middleware');
});

Route::prefix('/admin')->middleware(['admin.middleware']);
Route::prefix('/superadmin')->middleware(['super.admin.middleware']);

Route::get('/flood', fn() => Inertia::render('single-flood'));