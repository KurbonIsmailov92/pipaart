<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ScheduleController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('public.schedule.index', [
            'schedules' => Schedule::query()
                ->with('course')
                ->upcoming()
                ->paginate(10),
        ]);
    }
}
