<?php

use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminNewsPostController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', 'role:admin,teacher'])
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('courses', AdminCourseController::class)->except(['show']);
        Route::resource('schedule', AdminScheduleController::class)
            ->except(['show'])
            ->names('schedules');
        Route::resource('news', AdminNewsPostController::class)->except(['show']);

        Route::middleware('role:admin')->group(function (): void {
            Route::resource('pages', AdminPageController::class)->except(['show']);
            Route::resource('gallery', AdminGalleryController::class)->except(['show']);
            Route::resource('users', AdminUserController::class)->except(['show']);

            Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
        });
    });
