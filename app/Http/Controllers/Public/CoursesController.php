<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $courses = Course::query()
            ->search($request->string('search')->value())
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('public.courses.list', [
            'courses' => $courses,
        ]);
    }

    public function legacyIndex(string $locale): RedirectResponse
    {
        return redirect()->route('courses.index', ['locale' => $locale], 301);
    }

    public function show(Request $request, string $locale, Course $course): View|Factory|Application
    {
        return view('public.courses.show', [
            'course' => $course,
            'currentApplication' => $request->user()
                ? CourseApplication::query()
                    ->where('user_id', $request->user()->id)
                    ->where('course_id', $course->id)
                    ->active()
                    ->latest()
                    ->first()
                : null,
        ]);
    }
}
