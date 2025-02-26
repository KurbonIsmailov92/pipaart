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
    public function index(): View|Factory|Application
    {
        return view('courses.index');
    }

    public function list(): View|Factory|Application
    {
        $courses = Course::query()->get()->sortBy('id');
        return view('courses.list', ['courses' => $courses]);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function create(): View|Factory|Application
    {
        return view('courses.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('courses', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        Course::create($validated);

        return redirect()->route('courses.list')->with('success', 'Курс успешно добавлен!');
    }


    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $resource = Course::findOrFail($id);
        $resource->update($validated);

        return redirect()->route('courses.list')->with('success', 'Курс обновлён.');

    }

    public function destroy($id): RedirectResponse
    {
        $resource = Course::findOrFail($id);
        $resource->delete();

        return redirect()->route('courses.list')->with('success', 'Курс удален успешно.');
    }


    public function schedule(): View|Factory|Application
    {
        return view('courses.schedule');
    }

    public function reviews(): View|Factory|Application
    {
        return view('courses.reviews');
    }

    public function registration(): View|Factory|Application
    {
        return view('courses.registration');
    }

    public function trainingСenters(): View|Factory|Application
    {
        return view('courses.training-centers');
    }


}
