@props(['photo' => null])

@php
    $imageSrc = $photo?->image_path ? Storage::url($photo->image_path) : 'https://picsum.photos/500/400';
    $imageAlt = $photo?->title ?: 'Gallery photo';
    $description = $photo?->title ?: 'Gallery photo';
@endphp

<x-panel>
    <img src="{{ $imageSrc }}"
         alt="{{ $imageAlt }}"
         class="cursor-pointer rounded-xl border"
         onclick="showImageModal(this.src)">
    <div class="py-4">
        <div class="flex-1 px-4">
            <h4 class="text-lg font-semibold text-blue-900">{{ $description }}</h4>
        </div>
    </div>
</x-panel>
