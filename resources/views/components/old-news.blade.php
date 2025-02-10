@props(['title'])
<x-panel class="flex items-center bg-white/20 p-4 pb-3">
    <!-- Фото слева -->
    <div class="w-1/3 mr-10">
        <x-news-photo :width="220"/> <!-- Увеличенное фото -->
    </div>

    <!-- Текст справа -->
    <div class="flex-1 text-left">
        <div class="text-sm">
            <div class="py-4">
                <h3 class="group-hover:text-blue-800 text-xl font-bold transition-colors duration-300">
                    <a>
                        {{$title}}
                    </a>
                </h3>
                <p class="text-xl mt-4 text-left ">{{$slot}}</p>
            </div>
        </div>
    </div>
</x-panel>


