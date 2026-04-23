@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $page->title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $page->slug) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="content" class="mb-2 block text-sm font-medium text-slate-700">Content</label>
        <textarea id="content" name="content" rows="10" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('content', $page->content) }}</textarea>
        @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="meta_title" class="mb-2 block text-sm font-medium text-slate-700">Meta Title</label>
            <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $page->meta_title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
            @error('meta_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-end">
            <label class="flex items-center gap-3 rounded-xl border border-slate-300 px-4 py-3">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))>
                <span class="text-sm text-slate-700">Published</span>
            </label>
        </div>
    </div>

    <div>
        <label for="meta_description" class="mb-2 block text-sm font-medium text-slate-700">Meta Description</label>
        <textarea id="meta_description" name="meta_description" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('meta_description', $page->meta_description) }}</textarea>
        @error('meta_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.pages.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
