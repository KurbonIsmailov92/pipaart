<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index(): View|Factory|Application {
        return view('courses.index');
    }

    public function list(): View|Factory|Application {
       $courses = Course::query()->get()->sortBy('id');
       return view('courses.list', ['courses' => $courses]);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function create(): View|Factory|Application {
        return view('courses.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
        ]);
        Course::create($validated);
        return redirect()->route('courses.list')->with('success', 'Курс успешно добавлен!');
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Course::findOrFail($id);
        $resource->delete();

        return redirect()->route('courses.list')->with('success', 'Курс удален успешно.');
    }



    public function schedule(): View|Factory|Application {
        return view('courses.schedule');
    }

    public function reviews(): View|Factory|Application {
        return view('courses.reviews');
    }

    public function registration(): View|Factory|Application {
        return view('courses.registration');
    }

    public function trainingСenters(): View|Factory|Application {
        return view('courses.training-centers');
    }


}
