<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\NewsPost;
use App\Models\Schedule;
use App\Services\SettingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PageController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
    ) {
    }

    public function index(): View|Factory|Application
    {
        $defaults = [
            'site_name' => 'PIPAA CMS',
            'hero_title' => 'Professional accounting and audit education for the next generation of specialists.',
            'hero_subtitle' => 'Courses, schedules, certifications, and institute news managed from a single Laravel CMS.',
        ];

        return view('public.home.index', [
            'settings' => $this->settingsService->getPublicSettings($defaults),
            'featuredCourses' => Course::query()->ordered()->take(3)->get(),
            'featuredNews' => NewsPost::query()->published()->ordered()->take(3)->get(),
            'archiveNews' => NewsPost::query()->published()->ordered()->skip(3)->take(4)->get(),
            'upcomingSchedules' => Schedule::query()->with('course')->upcoming()->take(4)->get(),
        ]);
    }
}
