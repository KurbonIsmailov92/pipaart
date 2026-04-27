<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;
use App\Services\HomeHeroService;
use App\Services\SettingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Throwable;

class PageController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
        protected HomeHeroService $homeHeroService,
    ) {}

    public function index(): View|Factory|Application
    {
        $defaults = [
            'site_name' => 'PIPAA CMS',
            'hero_title' => __('ui.home.hero_title'),
            'hero_subtitle' => __('ui.home.hero_subtitle'),
        ];
        $locale = app()->getLocale();
        $heroDefaults = [
            'title' => __('ui.home.hero_title'),
            'subtitle' => __('ui.home.hero_subtitle'),
            'cta_text' => __('ui.home.browse_courses'),
            'cta_url' => route('courses.index', ['locale' => $locale]),
        ];
        $featuredCourses = new Collection;
        $featuredNews = new Collection;
        $archiveNews = new Collection;
        $upcomingSchedules = new Collection;
        $aboutPage = null;
        $certificationsPage = null;

        try {
            $featuredCourses = Course::query()->ordered()->take(3)->get();
            $featuredNews = NewsPost::query()->published()->ordered()->take(3)->get();
            $archiveNews = NewsPost::query()->published()->ordered()->skip(3)->take(4)->get();
            $upcomingSchedules = Schedule::query()->with('course')->upcoming()->take(4)->get();
            $aboutPage = Page::query()->published()->where('slug', 'about')->first();
            $certificationsPage = Page::query()->published()->where('slug', 'certifications')->first();
        } catch (Throwable $e) {
            report($e);
        }

        return view('public.home.index', [
            'settings' => $this->settingsService->getPublicSettings($defaults),
            'hero' => $this->homeHeroService->forLocale($locale, $heroDefaults),
            'featuredCourses' => $featuredCourses,
            'featuredNews' => $featuredNews,
            'archiveNews' => $archiveNews,
            'upcomingSchedules' => $upcomingSchedules,
            'aboutPage' => $aboutPage,
            'certificationsPage' => $certificationsPage,
        ]);
    }
}
