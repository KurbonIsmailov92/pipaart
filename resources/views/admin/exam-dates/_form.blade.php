@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="user_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.user') }}</label>
            <select id="user_id" name="user_id" class="ui-input">
                <option value="">{{ __('ui.common.none') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected((string) old('user_id', $exam->user_id) === (string) $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="course_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.course') }}</label>
            <select id="course_id" name="course_id" class="ui-input">
                <option value="">{{ __('ui.common.none') }}</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected((string) old('course_id', $exam->course_id) === (string) $course->id)>{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="title" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.title') }}</label>
            <input id="title" name="title" type="text" value="{{ old('title', $exam->title) }}" class="ui-input" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="exam_date" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.exam_date') }}</label>
            <input id="exam_date" name="exam_date" type="datetime-local" value="{{ old('exam_date', $exam->exam_date?->format('Y-m-d\TH:i')) }}" class="ui-input" required>
            @error('exam_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="location" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.location') }}</label>
        <input id="location" name="location" type="text" value="{{ old('location', $exam->location) }}" class="ui-input">
        @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.description') }}</label>
        <textarea id="description" name="description" rows="5" class="ui-input">{{ old('description', $exam->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.exam-dates.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.cancel') }}</a>
</div>
