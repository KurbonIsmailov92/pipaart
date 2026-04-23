@props(['photo' => null])

@php
    $imageSrc = $photo?->image ? Storage::url($photo->image) : 'https://picsum.photos/500/400';
    $imageAlt = $photo?->title ?: 'Gallery photo';
    $description = $photo?->title ?: 'Gallery photo';
@endphp

<x-panel>
    <img src="{{ $imageSrc }}"
         alt="{{ $imageAlt }}"
         class="rounded-xl border cursor-pointer"
         onclick="showImageModal(this.src)">
    <div class="py-4">
        <div class="flex-1 px-4">
            <h4 class="text-lg font-semibold text-blue-900">{{ $description }}</h4>
        </div>
    </div>
</x-panel>
