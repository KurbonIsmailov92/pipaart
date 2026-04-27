<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminCertificateController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('admin.certificates.index', [
            'certificates' => Certificate::query()
                ->with(['user', 'course'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View|Factory|Application
    {
        return view('admin.certificates.create', [
            'certificate' => new Certificate,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
            'statuses' => Certificate::statuses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Certificate::query()->create($this->validatedData($request));

        return redirect()->route('admin.certificates.index')->with('success', __('ui.flash.certificate_saved'));
    }

    public function edit(Certificate $certificate): View|Factory|Application
    {
        return view('admin.certificates.edit', [
            'certificate' => $certificate,
            'users' => User::query()->orderBy('name')->get(),
            'courses' => Course::query()->ordered()->get(),
            'statuses' => Certificate::statuses(),
        ]);
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $data = $this->validatedData($request);

        if (isset($data['file_path']) && $certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')->with('success', __('ui.flash.certificate_saved'));
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        if ($certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', __('ui.flash.certificate_deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'certificate_number' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'issued_at' => ['nullable', 'date'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'status' => ['required', Rule::in(Certificate::statuses())],
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('certificates', 'public');
        }

        unset($data['file']);

        return $data;
    }
}
