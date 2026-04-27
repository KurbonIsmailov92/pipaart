<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CourseSchedule;
use App\Models\ExamDate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CabinetController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $user = $request->user();
        $courseIds = $user->courseEnrollments()->pluck('course_id');

        return view('public.cabinet.index', [
            'activeCoursesCount' => $user->courseEnrollments()->active()->count(),
            'upcomingScheduleCount' => CourseSchedule::query()->whereIn('course_id', $courseIds)->upcoming()->count(),
            'certificatesCount' => $user->certificates()->count(),
            'upcomingExamsCount' => ExamDate::query()
                ->where(static function ($query) use ($user, $courseIds): void {
                    $query->where('user_id', $user->id)
                        ->orWhereIn('course_id', $courseIds);
                })
                ->upcoming()
                ->count(),
            'pendingApplicationsCount' => $user->courseApplications()->pending()->count(),
        ]);
    }

    public function courses(Request $request): View|Factory|Application
    {
        return view('public.cabinet.courses', [
            'enrollments' => $request->user()
                ->courseEnrollments()
                ->with('course')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function schedule(Request $request): View|Factory|Application
    {
        $courseIds = $request->user()->courseEnrollments()->pluck('course_id');

        return view('public.cabinet.schedule', [
            'schedules' => CourseSchedule::query()
                ->with('course')
                ->whereIn('course_id', $courseIds)
                ->upcoming()
                ->paginate(10),
        ]);
    }

    public function certificates(Request $request): View|Factory|Application
    {
        return view('public.cabinet.certificates', [
            'certificates' => $request->user()
                ->certificates()
                ->with('course')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function exams(Request $request): View|Factory|Application
    {
        $user = $request->user();
        $courseIds = $user->courseEnrollments()->pluck('course_id');

        return view('public.cabinet.exams', [
            'exams' => ExamDate::query()
                ->with(['course', 'user'])
                ->where(static function ($query) use ($user, $courseIds): void {
                    $query->where('user_id', $user->id)
                        ->orWhereIn('course_id', $courseIds);
                })
                ->upcoming()
                ->paginate(10),
        ]);
    }

    public function applications(Request $request): View|Factory|Application
    {
        return view('public.cabinet.applications', [
            'applications' => $request->user()
                ->courseApplications()
                ->with('course')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function downloadCertificate(Request $request, string $locale, Certificate $certificate)
    {
        abort_unless(
            $request->user()?->isAdmin() || $certificate->user_id === $request->user()?->id,
            403,
        );

        abort_if(blank($certificate->file_path), 404);
        abort_unless(Storage::disk('public')->exists($certificate->file_path), 404);

        return Storage::disk('public')->download($certificate->file_path);
    }
}
