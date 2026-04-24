@csrf

<div class="grid gap-6">
    <x-admin.translatable-input field="title" label="Title" :model="$newsPost" :required="false" />

    <x-admin.translatable-textarea field="content" label="Content" :model="$newsPost" :rows="8" />

    <div>
        <label for="published_at" class="mb-2 block text-sm font-medium text-slate-700">Published At</label>
        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $newsPost->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
        <p class="mt-2 text-xs text-slate-500">Leave empty to publish immediately.</p>
        @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl border border-dashed border-slate-300 px-4 py-3">
        @if($newsPost->image_url)
            <img src="{{ $newsPost->image_url }}" alt="{{ $newsPost->title }}" class="mt-3 h-28 rounded-xl object-cover">
        @endif
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.news.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
