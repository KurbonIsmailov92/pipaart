@csrf

<div class="grid gap-6">
    <x-admin.translatable-input field="title" label="Title" :model="$newsPost" :required="false" />

    <x-admin.translatable-textarea field="content" label="Content" :model="$newsPost" :rows="8" />

    @php
        $isPublished = old('is_published', $newsPost->exists ? (int) $newsPost->is_published : 1);
    @endphp

    <div>
        <input type="hidden" name="is_published" value="0">
        <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
            <input
                type="checkbox"
                name="is_published"
                value="1"
                class="h-4 w-4 rounded border-slate-300 text-slate-950 focus:ring-slate-400"
                @checked((string) $isPublished === '1')
            >
            Publish on the public site
        </label>
        <p class="mt-2 text-xs text-slate-500">Disable this to keep the post as a draft in the admin panel only.</p>
        @error('is_published') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="published_at" class="mb-2 block text-sm font-medium text-slate-700">Published At</label>
        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $newsPost->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">
        <p class="mt-2 text-xs text-slate-500">Leave empty to publish immediately. Future dates stay hidden until the scheduled time.</p>
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
