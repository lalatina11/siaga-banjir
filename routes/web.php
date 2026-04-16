<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageErrorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/auth', [AuthController::class, 'showAuthPage'])->name("login");
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/flood', fn() => Inertia::render('single-flood'));