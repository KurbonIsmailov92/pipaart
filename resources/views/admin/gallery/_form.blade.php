@csrf

<div class="grid gap-6">
    <div>
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $photo->title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category" class="mb-2 block text-sm font-medium text-slate-700">Category</label>
        <input id="category" name="category" type="text" value="{{ old('category', $photo->category) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
        <textarea id="description" name="description" rows="6" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('description', $photo->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
        <input id="image" name="image_path" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl border border-dashed border-slate-300 px-4 py-3" @if(! $photo->exists) required @endif>
        @if($photo->image_url)
            <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="mt-3 h-28 rounded-xl object-cover">
        @endif
        @error('image_path') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.gallery.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
