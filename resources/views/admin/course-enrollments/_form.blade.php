@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="user_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.user') }}</label>
            <select id="user_id" name="user_id" class="ui-input" required>
                <option value="">{{ __('ui.forms.select_user') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected((string) old('user_id', $enrollment->user_id) === (string) $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="course_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.course') }}</label>
            <select id="course_id" name="course_id" class="ui-input" required>
                <option value="">{{ __('ui.forms.select_course') }}</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected((string) old('course_id', $enrollment->course_id) === (string) $course->id)>{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.common.status') }}</label>
            <select id="status" name="status" class="ui-input" required>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $enrollment->status ?: 'active') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="started_at" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.started_at') }}</label>
            <input id="started_at" name="started_at" type="date" value="{{ old('started_at', $enrollment->started_at?->format('Y-m-d')) }}" class="ui-input">
            @error('started_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="completed_at" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.completed_at') }}</label>
            <input id="completed_at" name="completed_at" type="date" value="{{ old('completed_at', $enrollment->completed_at?->format('Y-m-d')) }}" class="ui-input">
            @error('completed_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.course-enrollments.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.cancel') }}</a>
</div>
