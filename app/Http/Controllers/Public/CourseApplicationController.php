<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseApplicationController extends Controller
{
    public function __construct(
        protected CourseApplicationService $courseApplicationService,
    ) {}

    public function store(Request $request, string $locale, Course $course): RedirectResponse
    {
        abort_unless($request->user()?->isStudent(), 403);

        $data = $request->validate([
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $application = $this->courseApplicationService->apply(
            $request->user(),
            $course,
            $data['comment'] ?? null,
        );

        $message = $application->wasRecentlyCreated
            ? __('ui.flash.course_application_submitted')
            : __('ui.flash.course_application_exists');

        return redirect()
            ->route('cabinet.applications', ['locale' => $locale])
            ->with('success', $message);
    }
}
