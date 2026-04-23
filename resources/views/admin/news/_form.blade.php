@csrf

<div class="grid gap-6">
    <div>
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $newsPost->title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="text" class="mb-2 block text-sm font-medium text-slate-700">Content</label>
        <textarea id="text" name="text" rows="8" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>{{ old('text', $newsPost->text) }}</textarea>
        @error('text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl border border-dashed border-slate-300 px-4 py-3">
        @if($newsPost->image)
            <img src="{{ Storage::url($newsPost->image) }}" alt="{{ $newsPost->title }}" class="mt-3 h-28 rounded-xl object-cover">
        @endif
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.news.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
