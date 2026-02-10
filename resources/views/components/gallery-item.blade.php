<x-panel>
    <img src="{{ asset('storage/gallery/'.$photo->image) }}"
         alt="{{$photo->title}}"
         class="rounded-xl border cursor-pointer"
         onclick="showImageModal(this.src)">
    <div class="py-4">
        <div class="flex-1 px-4">
            <h4 class="text-lg font-semibold text-blue-900">Описание фото</h4>
        </div>
    </div>
</x-panel>
