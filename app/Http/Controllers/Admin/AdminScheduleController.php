<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Course;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminScheduleController extends Controller
{
    public function __construct(
        protected ScheduleService $scheduleService,
    ) {
    }

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Schedule::class);

        return view('admin.schedules.index', [
            'schedules' => Schedule::query()->with('course')->upcoming()->paginate(10),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', Schedule::class);

        return view('admin.schedules.create', [
            'schedule' => new Schedule(),
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        $this->scheduleService->create($request->validated());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule): View|Factory|Application
    {
        $this->authorize('update', $schedule);

        return view('admin.schedules.edit', [
            'schedule' => $schedule,
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule): RedirectResponse
    {
        $this->scheduleService->update($schedule, $request->validated());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $this->authorize('delete', $schedule);

        $this->scheduleService->delete($schedule);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
