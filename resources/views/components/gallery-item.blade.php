@props(['photo' => null])

@php
    $imageSrc = $photo?->image ? asset('storage/gallery/' . $photo->image) : 'https://picsum.photos/500/400';
    $imageAlt = $photo?->title ?: 'Фото';
    $description = $photo?->title ?: 'Описание фото';
@endphp

<x-panel>
<<<<<<< HEAD
    <img src="{{ asset('storage/gallery/'.$photo->image) }}"
         alt="{{$photo->title}}"
=======
    <img src="{{ $imageSrc }}"
         alt="{{ $imageAlt }}"
>>>>>>> 87b16771c9a22949187d8ea2951cc85eb0c93439
         class="rounded-xl border cursor-pointer"
         onclick="showImageModal(this.src)">
    <div class="py-4">
        <div class="flex-1 px-4">
            <h4 class="text-lg font-semibold text-blue-900">{{ $description }}</h4>
        </div>
    </div>
</x-panel>
