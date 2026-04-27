<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ExamDate;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminExamDateController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('admin.exam-dates.index', [
            'exams' => ExamDate::query()
                ->with(['user', 'course'])
                ->orderByDesc('exam_date')
                ->paginate(15),
        ]);
    }

    public function create(): View|Factory|Application
    {
        return view('admin.exam-dates.create', [
            'exam' => new ExamDate,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ExamDate::query()->create($request->validate($this->rules()));

        return redirect()->route('admin.exam-dates.index')->with('success', __('ui.flash.exam_saved'));
    }

    public function edit(ExamDate $examDate): View|Factory|Application
    {
        return view('admin.exam-dates.edit', [
            'exam' => $examDate,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
        ]);
    }

    public function update(Request $request, ExamDate $examDate): RedirectResponse
    {
        $examDate->update($request->validate($this->rules()));

        return redirect()->route('admin.exam-dates.index')->with('success', __('ui.flash.exam_saved'));
    }

    public function destroy(ExamDate $examDate): RedirectResponse
    {
        $examDate->delete();

        return redirect()->route('admin.exam-dates.index')->with('success', __('ui.flash.exam_deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'exam_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
