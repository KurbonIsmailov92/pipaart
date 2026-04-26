<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminCourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService,
    ) {}

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Course::class);

        return view('admin.courses.index', [
            'courses' => Course::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', Course::class);

        return view('admin.courses.create', [
            'course' => new Course,
        ]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->courseService->create($request->validated());

        return redirect()->route('admin.courses.index')->with('success', __('ui.flash.course_created'));
    }

    public function edit(Course $course): View|Factory|Application
    {
        $this->authorize('update', $course);

        return view('admin.courses.edit', [
            'course' => $course,
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->courseService->update($course, $request->validated());

        return redirect()->route('admin.courses.index')->with('success', __('ui.flash.course_updated'));
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course);

        return redirect()->route('admin.courses.index')->with('success', __('ui.flash.course_deleted'));
    }
}
