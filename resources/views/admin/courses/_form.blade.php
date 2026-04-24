@csrf

<div class="grid gap-6">
    <x-admin.translatable-input field="title" label="Title" :model="$course" />

    <x-admin.translatable-textarea field="description" label="Description" :model="$course" :rows="6" />

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="duration" class="mb-2 block text-sm font-medium text-slate-700">Duration</label>
            <input id="duration" name="duration" type="text" value="{{ old('duration', $course->duration) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('duration') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="hours" class="mb-2 block text-sm font-medium text-slate-700">Hours</label>
            <input id="hours" name="hours" type="number" min="1" max="1000" value="{{ old('hours', $course->hours) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
            @error('hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="price" class="mb-2 block text-sm font-medium text-slate-700">Price</label>
            <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $course->price) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div></div>
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl border border-dashed border-slate-300 px-4 py-3">
        @if($course->image)
            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="mt-3 h-28 rounded-xl object-cover">
        @endif
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.courses.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
