<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Throwable;

class DashboardController extends Controller
{
    public function __invoke(): View|Factory|Application
    {
        $stats = [
            'pages' => 0,
            'courses' => 0,
            'schedules' => 0,
            'news' => 0,
            'gallery' => 0,
            'users' => 0,
        ];
        $latestCourses = new Collection();
        $latestNews = new Collection();
        $latestSchedules = new Collection();

        try {
            $stats = [
                'pages' => Page::query()->count(),
                'courses' => Course::query()->count(),
                'schedules' => Schedule::query()->count(),
                'news' => NewsPost::query()->count(),
                'gallery' => Gallery::query()->count(),
                'users' => User::query()->count(),
            ];
            $latestCourses = Course::query()->latest()->take(5)->get();
            $latestNews = NewsPost::query()->ordered()->take(5)->get();
            $latestSchedules = Schedule::query()->with('course')->upcoming()->take(6)->get();
        } catch (Throwable) {
            //
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestCourses' => $latestCourses,
            'latestNews' => $latestNews,
            'latestSchedules' => $latestSchedules,
        ]);
    }
}
