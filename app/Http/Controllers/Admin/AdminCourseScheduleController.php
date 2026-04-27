<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSchedule;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCourseScheduleController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('admin.course-schedules.index', [
            'schedules' => CourseSchedule::query()
                ->with('course')
                ->orderByDesc('starts_at')
                ->paginate(15),
        ]);
    }

    public function create(): View|Factory|Application
    {
        return view('admin.course-schedules.create', [
            'schedule' => new CourseSchedule,
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CourseSchedule::query()->create($request->validate($this->rules()));

        return redirect()->route('admin.course-schedules.index')->with('success', __('ui.flash.course_schedule_saved'));
    }

    public function edit(CourseSchedule $courseSchedule): View|Factory|Application
    {
        return view('admin.course-schedules.edit', [
            'schedule' => $courseSchedule,
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function update(Request $request, CourseSchedule $courseSchedule): RedirectResponse
    {
        $courseSchedule->update($request->validate($this->rules()));

        return redirect()->route('admin.course-schedules.index')->with('success', __('ui.flash.course_schedule_saved'));
    }

    public function destroy(CourseSchedule $courseSchedule): RedirectResponse
    {
        $courseSchedule->delete();

        return redirect()->route('admin.course-schedules.index')->with('success', __('ui.flash.course_schedule_deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'location' => ['nullable', 'string', 'max:255'],
            'teacher' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
