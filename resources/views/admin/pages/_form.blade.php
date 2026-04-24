@csrf

<div class="grid gap-6">
    <div class="grid gap-6 md:grid-cols-2">
        <x-admin.translatable-input field="title" label="Title" :model="$page" :required="false" />
        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $page->slug) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <x-admin.translatable-textarea field="content" label="Content" :model="$page" :rows="10" :required="false" />

    <div class="grid gap-6 md:grid-cols-2">
        <x-admin.translatable-input field="meta_title" label="Meta Title" :model="$page" :required="false" />
        <div class="flex items-end">
            <label class="flex items-center gap-3 rounded-xl border border-slate-300 px-4 py-3">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))>
                <span class="text-sm text-slate-700">Published</span>
            </label>
        </div>
    </div>

    <x-admin.translatable-textarea field="meta_description" label="Meta Description" :model="$page" :rows="4" :required="false" />
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.pages.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
