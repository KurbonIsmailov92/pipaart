<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login.store');
        Route::post('/sign-in', [AuthController::class, 'login'])->name('auth.sign-in');

        Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.register');
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');
        Route::get('/sign-up', [AuthController::class, 'signUp'])->name('auth.sign-up');
        Route::post('/sign-up', [AuthController::class, 'store'])->name('auth.sign-up.store');

        Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
        Route::get('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('auth.logout');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
