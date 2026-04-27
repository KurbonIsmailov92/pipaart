@csrf

<div class="grid gap-6">
    <div>
        <label for="course_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.course') }}</label>
        <select id="course_id" name="course_id" class="ui-input" required>
            <option value="">{{ __('ui.forms.select_course') }}</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected((string) old('course_id', $schedule->course_id) === (string) $course->id)>{{ $course->title }}</option>
            @endforeach
        </select>
        @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.title') }}</label>
        <input id="title" name="title" type="text" value="{{ old('title', $schedule->title) }}" class="ui-input" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="starts_at" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.starts_at') }}</label>
            <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at', $schedule->starts_at?->format('Y-m-d\TH:i')) }}" class="ui-input" required>
            @error('starts_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="ends_at" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.ends_at') }}</label>
            <input id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at', $schedule->ends_at?->format('Y-m-d\TH:i')) }}" class="ui-input">
            @error('ends_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="teacher" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.teacher') }}</label>
            <input id="teacher" name="teacher" type="text" value="{{ old('teacher', $schedule->teacher) }}" class="ui-input">
            @error('teacher') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="location" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.location') }}</label>
            <input id="location" name="location" type="text" value="{{ old('location', $schedule->location) }}" class="ui-input">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.description') }}</label>
        <textarea id="description" name="description" rows="5" class="ui-input">{{ old('description', $schedule->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.course-schedules.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.cancel') }}</a>
</div>
