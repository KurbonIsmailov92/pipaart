<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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

    public function show(Course $course): View|Factory|Application
    {
        return view('public.courses.show', [
            'course' => $course,
        ]);
    }
}
