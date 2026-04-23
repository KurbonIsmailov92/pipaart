@csrf

<div class="grid gap-6">
    <div>
        <label for="course_id" class="mb-2 block text-sm font-medium text-slate-700">Course</label>
        <select id="course_id" name="course_id" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            <option value="">Select a course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected((string) old('course_id', $schedule->course_id) === (string) $course->id)>{{ $course->title }}</option>
            @endforeach
        </select>
        @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">Start Date</label>
            <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $schedule->start_date?->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="teacher" class="mb-2 block text-sm font-medium text-slate-700">Teacher</label>
            <input id="teacher" name="teacher" type="text" value="{{ old('teacher', $schedule->teacher) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('teacher') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="schedule_text" class="mb-2 block text-sm font-medium text-slate-700">Schedule Text</label>
        <textarea id="schedule_text" name="schedule_text" rows="6" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>{{ old('schedule_text', $schedule->schedule_text) }}</textarea>
        @error('schedule_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.schedules.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
