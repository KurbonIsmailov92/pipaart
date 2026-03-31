<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('courses.index');
    }

    public function list(Request $request): View|Factory|Application
    {
        $query = Course::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }
        // Если потребуется подгружать связи: ->with('instructor')
        $courses = $query->orderBy('id')->paginate(10);
        return view('courses.list', ['courses' => $courses]);
    }

    public function show(Course $course): View|Factory|Application
    {
        return view('courses.show', compact('course'));
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', Course::class);
        return view('courses.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Course::class);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imageName = uniqid('course_', true) . '.' . $request->image->extension();
            $request->image->storeAs('courses', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        Course::create($validated);

        return redirect()->route('courses.list')->with('success', __('Курс успешно добавлен!'));
    }


    public function edit(Course $course): View|Factory|Application
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            if ($course->image && Storage::disk('public')->exists('courses/' . $course->image)) {
                Storage::disk('public')->delete('courses/' . $course->image);
            }

            $imageName = uniqid('course_', true) . '.' . $request->image->extension();
            $request->image->storeAs('courses', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        $course->update($validated);

        return redirect()->route('courses.list')->with('success', __('Курс обновлён.'));

    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);

        if ($course->image && Storage::disk('public')->exists('courses/' . $course->image)) {
            Storage::disk('public')->delete('courses/' . $course->image);
        }

        $course->delete();

        return redirect()->route('courses.list')->with('success', __('Курс удален успешно.'));
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
