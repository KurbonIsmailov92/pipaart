<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\User;
use App\Services\CourseApplicationService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCourseApplicationController extends Controller
{
    public function __construct(
        protected CourseApplicationService $courseApplicationService,
    ) {}

    public function index(Request $request): View|Factory|Application
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(CourseApplication::statuses())],
            'course_id' => ['nullable', 'exists:courses,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $applications = CourseApplication::query()
            ->with(['user', 'course', 'reviewer'])
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['course_id'] ?? null, fn ($query, string $courseId) => $query->where('course_id', $courseId))
            ->when($filters['user_id'] ?? null, fn ($query, string $userId) => $query->where('user_id', $userId))
            ->when($filters['date_from'] ?? null, fn ($query, string $date) => $query->whereDate('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, string $date) => $query->whereDate('created_at', '<=', $date))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.course-applications.index', [
            'applications' => $applications,
            'statuses' => CourseApplication::statuses(),
            'courses' => Course::query()->ordered()->get(),
            'users' => User::query()->orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function show(CourseApplication $courseApplication): View|Factory|Application
    {
        return view('admin.course-applications.show', [
            'application' => $courseApplication->load(['user', 'course', 'reviewer']),
        ]);
    }

    public function approve(Request $request, CourseApplication $courseApplication): RedirectResponse
    {
        $data = $request->validate([
            'admin_comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $this->courseApplicationService->approve(
            $courseApplication,
            $request->user(),
            $data['admin_comment'] ?? null,
        );

        return redirect()->route('admin.course-applications.show', $courseApplication)
            ->with('success', __('ui.flash.course_application_approved'));
    }

    public function reject(Request $request, CourseApplication $courseApplication): RedirectResponse
    {
        $data = $request->validate([
            'admin_comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $this->courseApplicationService->reject(
            $courseApplication,
            $request->user(),
            $data['admin_comment'] ?? null,
        );

        return redirect()->route('admin.course-applications.show', $courseApplication)
            ->with('success', __('ui.flash.course_application_rejected'));
    }
}
