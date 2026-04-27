@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="user_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.user') }}</label>
            <select id="user_id" name="user_id" class="ui-input" required>
                <option value="">{{ __('ui.forms.select_user') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected((string) old('user_id', $certificate->user_id) === (string) $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="course_id" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.course') }}</label>
            <select id="course_id" name="course_id" class="ui-input">
                <option value="">{{ __('ui.common.none') }}</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected((string) old('course_id', $certificate->course_id) === (string) $course->id)>{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.title') }}</label>
        <input id="title" name="title" type="text" value="{{ old('title', $certificate->title) }}" class="ui-input" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label for="certificate_number" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.certificate_number') }}</label>
            <input id="certificate_number" name="certificate_number" type="text" value="{{ old('certificate_number', $certificate->certificate_number) }}" class="ui-input">
            @error('certificate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="issued_at" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.issued_at') }}</label>
            <input id="issued_at" name="issued_at" type="date" value="{{ old('issued_at', $certificate->issued_at?->format('Y-m-d')) }}" class="ui-input">
            @error('issued_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.common.status') }}</label>
            <select id="status" name="status" class="ui-input" required>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $certificate->status ?: 'issued') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="file" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.cabinet.certificate_file') }}</label>
        <input id="file" name="file" type="file" class="ui-input">
        @if($certificate->file_path)
            <p class="mt-2 text-sm text-slate-500">{{ $certificate->file_path }}</p>
        @endif
        @error('file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.certificates.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.cancel') }}</a>
</div>
