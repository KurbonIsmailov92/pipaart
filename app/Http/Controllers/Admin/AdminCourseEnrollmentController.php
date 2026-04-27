<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCourseEnrollmentController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('admin.course-enrollments.index', [
            'enrollments' => CourseEnrollment::query()
                ->with(['user', 'course'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View|Factory|Application
    {
        return view('admin.course-enrollments.create', [
            'enrollment' => new CourseEnrollment,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
            'statuses' => CourseEnrollment::statuses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CourseEnrollment::query()->updateOrCreate(
            $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'course_id' => ['required', 'exists:courses,id'],
            ]),
            $request->validate($this->rules()),
        );

        return redirect()->route('admin.course-enrollments.index')->with('success', __('ui.flash.enrollment_saved'));
    }

    public function edit(CourseEnrollment $courseEnrollment): View|Factory|Application
    {
        return view('admin.course-enrollments.edit', [
            'enrollment' => $courseEnrollment,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
            'statuses' => CourseEnrollment::statuses(),
        ]);
    }

    public function update(Request $request, CourseEnrollment $courseEnrollment): RedirectResponse
    {
        $courseEnrollment->update($request->validate($this->rules()));

        return redirect()->route('admin.course-enrollments.index')->with('success', __('ui.flash.enrollment_saved'));
    }

    public function destroy(CourseEnrollment $courseEnrollment): RedirectResponse
    {
        $courseEnrollment->delete();

        return redirect()->route('admin.course-enrollments.index')->with('success', __('ui.flash.enrollment_deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'status' => ['required', Rule::in(CourseEnrollment::statuses())],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:started_at'],
        ];
    }
}
