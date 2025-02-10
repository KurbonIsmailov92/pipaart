
<x-panel class="flex flex-col text-center">
    <a href="{{$argc}}">
    <div class="flex justify-center items-center mt-auto">
        <x-news-photo :width="360"/>
    </div>
    <div class="py-8">
        <div class="flex-1 px-4">
            <h3 class="text-lg font-semibold text-blue-900">{{$title}}</h3>
            <p class="text-sm sm:text-base">{{$slot}}</p>
        </div>
    </div>
    </a>
</x-panel>
