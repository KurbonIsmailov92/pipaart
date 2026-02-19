<?php

use App\Http\Controllers\AboutPipaaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CipaController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\GarpController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\NewsPostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::prefix('oipba')->group(function () {
    Route::get('/', [AboutPipaaController::class, 'index'])->name('oipba.index');
    Route::get('/work', [AboutPipaaController::class, 'work'])->name('oipba.work');
    Route::get('/membership', [AboutPipaaController::class, 'membership'])->name('oipba.membership');
    Route::get('/partners', [AboutPipaaController::class, 'partners'])->name('oipba.partners');
    Route::get('/customers', [AboutPipaaController::class, 'customers'])->name('oipba.customers');
    Route::get('/collective', [AboutPipaaController::class, 'collective'])->name('oipba.collective');
    Route::get('/gallery', [AboutPipaaController::class, 'gallery'])->name('oipba.gallery');
});

Route::prefix('courses')->group(function () {
    Route::get('/', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('/list', [CoursesController::class, 'list'])->name('courses.list');
    Route::get('/schedule', [CoursesController::class, 'schedule'])->name('courses.schedule');
    Route::get('/reviews', [CoursesController::class, 'reviews'])->name('courses.reviews');
    Route::get('/registration', [CoursesController::class, 'registration'])->name('courses.registration');
    Route::get('/training-centers', [CoursesController::class, 'trainingСenters'])->name('courses.training-centers');

    Route::get('/create', [CoursesController::class, 'create'])->name('courses.create');
    Route::post('/list', [CoursesController::class, 'store'])->name('courses.store');

    Route::get('/{course}', [CoursesController::class, 'show'])->name('courses.show');
    Route::get('/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/{course}', [CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/{course}', [CoursesController::class, 'destroy'])->name('courses.delete');
});

Route::prefix('cipa')->group(function () {
    Route::get('/', [CipaController::class, 'index'])->name('cipa.index');
    Route::get('/schedule', [CipaController::class, 'schedule'])->name('cipa.schedule');
    Route::get('/registration', [CipaController::class, 'registration'])->name('cipa.registration');
    Route::get('/appeal', [CipaController::class, 'appeal'])->name('cipa.appeal');
    Route::get('/rules', [CipaController::class, 'rules'])->name('cipa.rules');
    Route::get('/id', [CipaController::class, 'id'])->name('cipa.id');
    Route::get('/certification', [CipaController::class, 'certification'])->name('cipa.certification');
    Route::get('/certificates', [CipaController::class, 'certificates'])->name('cipa.certificates');
});

Route::prefix('garp')->group(function () {
    Route::get('/', [GarpController::class, 'index'])->name('garp.index');
    Route::get('/schedule', [GarpController::class, 'schedule'])->name('garp.schedule');
    Route::get('/registration', [GarpController::class, 'registration'])->name('garp.registration');
    Route::get('/certification', [GarpController::class, 'certification'])->name('garp.certification');
    Route::get('/topic', [GarpController::class, 'topic'])->name('garp.topic');
});

Route::prefix('library')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/docs', [LibraryController::class, 'docs'])->name('library.docs');
    Route::get('/books', [LibraryController::class, 'books'])->name('library.books');
    Route::get('/for-cipa', [LibraryController::class, 'forCipa'])->name('library.for-cipa');
    Route::get('/links', [LibraryController::class, 'links'])->name('library.links');
});

Route::prefix('news')->group(function () {
    Route::get('/list', [NewsPostController::class, 'index'])->name('news.list');
    Route::get('/create', [NewsPostController::class, 'create'])->name('news.create');
    Route::post('/list', [NewsPostController::class, 'store'])->name('news.store');
    Route::get('/{newsPost}', [NewsPostController::class, 'show'])->name('news.show');
    Route::get('/{newsPost}/edit', [NewsPostController::class, 'edit'])->name('news.edit');
    Route::put('/{newsPost}', [NewsPostController::class, 'update'])->name('news.update');
    Route::delete('/{newsPost}', [NewsPostController::class, 'destroy'])->name('news.delete');
});

Route::resource('/gallery', GalleryController::class);

Route::get('/search', SearchController::class);

Route::middleware('guest')->prefix('auth')->name('auth.')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
        Route::post('/login', [AuthController::class, 'signIn'])->name('auth.sign-in');

        Route::get('/register', [AuthController::class, 'signUp'])->name('auth.sign-up');
        Route::post('/register', [AuthController::class, 'store'])->name('auth.sign-up.store');

        Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
        Route::get('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');
});
