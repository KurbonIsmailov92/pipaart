<?php

use App\Http\Controllers\Admin\AdminCertificateController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminCourseApplicationController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminCourseEnrollmentController;
use App\Http\Controllers\Admin\AdminCourseScheduleController;
use App\Http\Controllers\Admin\AdminExamDateController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminHomeHeroController;
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
        Route::get('course-applications', [AdminCourseApplicationController::class, 'index'])->name('course-applications.index');
        Route::get('course-applications/{courseApplication}', [AdminCourseApplicationController::class, 'show'])->name('course-applications.show');
        Route::patch('course-applications/{courseApplication}/approve', [AdminCourseApplicationController::class, 'approve'])->name('course-applications.approve');
        Route::patch('course-applications/{courseApplication}/reject', [AdminCourseApplicationController::class, 'reject'])->name('course-applications.reject');

        Route::middleware('role:admin')->group(function (): void {
            Route::resource('pages', AdminPageController::class)->except(['show']);
            Route::resource('gallery', AdminGalleryController::class)->except(['show']);
            Route::resource('users', AdminUserController::class)->except(['show']);
            Route::get('home-heroes', [AdminHomeHeroController::class, 'index'])->name('home-heroes.index');
            Route::get('home-heroes/{homeHero}/edit', [AdminHomeHeroController::class, 'edit'])->name('home-heroes.edit');
            Route::put('home-heroes/{homeHero}', [AdminHomeHeroController::class, 'update'])->name('home-heroes.update');
            Route::resource('course-enrollments', AdminCourseEnrollmentController::class)->except(['show']);
            Route::resource('course-schedules', AdminCourseScheduleController::class)->except(['show']);
            Route::resource('certificates', AdminCertificateController::class)->except(['show']);
            Route::resource('exam-dates', AdminExamDateController::class)->except(['show']);
            Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
            Route::get('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
            Route::patch('contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markRead'])->name('contact-messages.read');
            Route::patch('contact-messages/{contactMessage}/unread', [AdminContactMessageController::class, 'markUnread'])->name('contact-messages.unread');
            Route::delete('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

            Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
        });
    });
