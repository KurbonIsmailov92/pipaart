<?php

use App\Http\Controllers\AboutPipaaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CipaController;
use App\Http\Controllers\GarpController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Public\CoursesController as PublicCoursesController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\MessageController as PublicMessageController;
use App\Http\Controllers\Public\NewsPostController as PublicNewsPostController;
use App\Http\Controllers\Public\PageContentController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ScheduleController as PublicScheduleController;
use App\Http\Controllers\Public\SearchController as PublicSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$supportedLocalesPattern = implode('|', config('app.supported_locales', ['ru', 'tg', 'en']));

Route::get('/up', static function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

Route::get('/', static function (Request $request) {
    return redirect()->route('home', [
        'locale' => $request->session()->get('locale', config('app.locale', 'ru')),
    ]);
});

Route::prefix('{locale}')
    ->where(['locale' => $supportedLocalesPattern])
    ->middleware('locale')
    ->group(function (): void {
        Route::get('/', [PageController::class, 'index'])->name('home');
        Route::get('/about', [PageContentController::class, 'show'])->defaults('slug', 'about')->name('about');
        Route::get('/certifications', [PageContentController::class, 'show'])->defaults('slug', 'certifications')->name('certifications');

        Route::get('/courses', [PublicCoursesController::class, 'index'])->name('courses.index');
        Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/news', [PublicNewsPostController::class, 'index'])->name('news.index');
        Route::get('/gallery', [PublicGalleryController::class, 'index'])->name('gallery.index');
        Route::get('/contact', [PublicContactController::class, 'info'])->name('contact');

        Route::prefix('oipba')->group(function (): void {
            Route::get('/', [AboutPipaaController::class, 'index'])->name('oipba.index');
            Route::get('/work', [AboutPipaaController::class, 'work'])->name('oipba.work');
            Route::get('/membership', [AboutPipaaController::class, 'membership'])->name('oipba.membership');
            Route::get('/partners', [AboutPipaaController::class, 'partners'])->name('oipba.partners');
            Route::get('/customers', [AboutPipaaController::class, 'customers'])->name('oipba.customers');
            Route::get('/collective', [AboutPipaaController::class, 'collective'])->name('oipba.collective');
            Route::get('/gallery', [AboutPipaaController::class, 'gallery'])->name('oipba.gallery');
        });

        Route::prefix('courses')->name('courses.')->group(function (): void {
            Route::get('/list', [PublicCoursesController::class, 'index'])->name('list');
            Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule');
            Route::view('/reviews', 'courses.reviews')->name('reviews');
            Route::view('/registration', 'courses.registration')->name('registration');
            Route::view('/training-centers', 'courses.training-centers')->name('training-centers');
            Route::get('/{course}', [PublicCoursesController::class, 'show'])->name('show');
        });

        Route::prefix('cipa')->group(function (): void {
            Route::get('/', [CipaController::class, 'index'])->name('cipa.index');
            Route::get('/schedule', [CipaController::class, 'schedule'])->name('cipa.schedule');
            Route::get('/registration', [CipaController::class, 'registration'])->name('cipa.registration');
            Route::get('/appeal', [CipaController::class, 'appeal'])->name('cipa.appeal');
            Route::get('/rules', [CipaController::class, 'rules'])->name('cipa.rules');
            Route::get('/id', [CipaController::class, 'id'])->name('cipa.id');
            Route::get('/certification', [CipaController::class, 'certification'])->name('cipa.certification');
            Route::get('/certificates', [CipaController::class, 'certificates'])->name('cipa.certificates');
        });

        Route::prefix('garp')->group(function (): void {
            Route::get('/', [GarpController::class, 'index'])->name('garp.index');
            Route::get('/schedule', [GarpController::class, 'schedule'])->name('garp.schedule');
            Route::get('/registration', [GarpController::class, 'registration'])->name('garp.registration');
            Route::get('/certification', [GarpController::class, 'certification'])->name('garp.certification');
            Route::get('/topic', [GarpController::class, 'topic'])->name('garp.topic');
        });

        Route::prefix('library')->group(function (): void {
            Route::get('/', [LibraryController::class, 'index'])->name('library.index');
            Route::get('/docs', [LibraryController::class, 'docs'])->name('library.docs');
            Route::get('/books', [LibraryController::class, 'books'])->name('library.books');
            Route::get('/for-cipa', [LibraryController::class, 'forCipa'])->name('library.for-cipa');
            Route::get('/links', [LibraryController::class, 'links'])->name('library.links');
        });

        Route::prefix('contacts')->name('contacts.')->group(function (): void {
            Route::get('/', [PublicContactController::class, 'info'])->name('index');
            Route::get('/info', [PublicContactController::class, 'info'])->name('info');
            Route::get('/message', [PublicMessageController::class, 'create'])->name('message');
            Route::post('/message', [PublicMessageController::class, 'store'])->name('message.store');
        });

        Route::prefix('news')->name('news.')->group(function (): void {
            Route::get('/list', [PublicNewsPostController::class, 'index'])->name('list');
            Route::get('/{newsPost}', [PublicNewsPostController::class, 'show'])->name('show');
        });

        Route::get('/gallery/{gallery}', [PublicGalleryController::class, 'show'])->name('gallery.show');
        Route::get('/search', PublicSearchController::class)->name('search');
    });

Route::prefix('auth')->name('auth.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.store');

        Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');

        Route::get('/sign-up', [AuthController::class, 'signUp'])->name('sign-up');
        Route::post('/sign-up', [AuthController::class, 'store'])->name('sign-up.store');

        Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.request');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
        Route::get('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});
