<?php

use App\Http\Controllers\AboutPipaaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CipaController;
use App\Http\Controllers\GarpController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Public\CoursesController as PublicCoursesController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\MediaController;
use App\Http\Controllers\Public\MessageController as PublicMessageController;
use App\Http\Controllers\Public\NewsPostController as PublicNewsPostController;
use App\Http\Controllers\Public\PageContentController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\RootRedirectController;
use App\Http\Controllers\Public\ScheduleController as PublicScheduleController;
use App\Http\Controllers\Public\SearchController as PublicSearchController;
use Illuminate\Support\Facades\Route;

/** @var list<string> $supportedLocales */
$supportedLocales = config('app.supported_locales', ['ru', 'tg', 'en']);
$supportedLocalesPattern = implode('|', array_map(
    static fn (string $locale): string => preg_quote($locale, '/'),
    $supportedLocales,
));

Route::get('/', RootRedirectController::class);

Route::get('/media/public/{path}', MediaController::class)
    ->where('path', '.*')
    ->name('media.public');

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

Route::prefix('{locale}')
    ->where(['locale' => $supportedLocalesPattern])
    ->middleware('locale')
    ->group(function (): void {
        Route::get('/', [PageController::class, 'index'])->name('home');

        Route::get('/about', [PageContentController::class, 'about'])->name('about');
        Route::get('/certifications', [PageContentController::class, 'certifications'])->name('certifications');

        Route::prefix('oipba')
            ->name('oipba.')
            ->controller(AboutPipaaController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/work', 'work')->name('work');
                Route::get('/membership', 'membership')->name('membership');
                Route::get('/partners', 'partners')->name('partners');
                Route::get('/customers', 'customers')->name('customers');
                Route::get('/collective', 'collective')->name('collective');
                Route::get('/gallery', 'gallery')->name('gallery');
            });

        Route::prefix('courses')->name('courses.')->group(function (): void {
            Route::get('/', [PublicCoursesController::class, 'index'])->name('index');
            Route::get('/list', [PublicCoursesController::class, 'index'])->name('list');
            Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule');
            Route::view('/reviews', 'courses.reviews')->name('reviews');
            Route::view('/registration', 'courses.registration')->name('registration');
            Route::view('/training-centers', 'courses.training-centers')->name('training-centers');
            Route::get('/{course}', [PublicCoursesController::class, 'show'])->name('show');
        });

        Route::prefix('cipa')
            ->name('cipa.')
            ->controller(CipaController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/schedule', 'schedule')->name('schedule');
                Route::get('/registration', 'registration')->name('registration');
                Route::get('/appeal', 'appeal')->name('appeal');
                Route::get('/rules', 'rules')->name('rules');
                Route::get('/id', 'id')->name('id');
                Route::get('/certification', 'certification')->name('certification');
                Route::get('/certificates', 'certificates')->name('certificates');
            });

        Route::prefix('garp')
            ->name('garp.')
            ->controller(GarpController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/schedule', 'schedule')->name('schedule');
                Route::get('/registration', 'registration')->name('registration');
                Route::get('/certification', 'certification')->name('certification');
                Route::get('/topic', 'topic')->name('topic');
            });

        Route::prefix('library')
            ->name('library.')
            ->controller(LibraryController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/docs', 'docs')->name('docs');
                Route::get('/books', 'books')->name('books');
                Route::get('/for-cipa', 'forCipa')->name('for-cipa');
                Route::get('/links', 'links')->name('links');
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

        Route::get('/gallery', [PublicGalleryController::class, 'index'])->name('gallery.index');
        Route::get('/gallery/{gallery}', [PublicGalleryController::class, 'show'])->name('gallery.show');
        Route::get('/search', PublicSearchController::class)->name('search');

        Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/news', [PublicNewsPostController::class, 'index'])->name('news.index');
        Route::get('/contact', [PublicContactController::class, 'info'])->name('contact');
    });
