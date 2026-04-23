<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function __invoke(): View|Factory|Application
    {
        return view('admin.dashboard', [
            'stats' => [
                'pages' => Page::query()->count(),
                'courses' => Course::query()->count(),
                'schedules' => Schedule::query()->count(),
                'news' => NewsPost::query()->count(),
                'gallery' => Gallery::query()->count(),
                'users' => User::query()->count(),
            ],
            'recentCourses' => Course::query()->latest()->take(5)->get(),
            'recentNews' => NewsPost::query()->ordered()->take(5)->get(),
        ]);
    }
}
