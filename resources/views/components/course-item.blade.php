@props(['title', 'text', 'argc'])

<x-panel class="flex items-center bg-white/20 p-4 pb-3">
    <!-- Фото слева -->
    <div class="w-1/3 ml-5 flex items-center">
        <x-news-photo :width="350"/> <!-- Увеличенное фото -->
    </div>

    <!-- Текст справа -->
    <div class="flex-1 text-left">
        <div class="text-sm"></div>
        <div class="py-4">
            <a href="{{$argc}}">
                <h3 class="group-hover:text-blue-800 text-xl font-bold transition-colors duration-300">
                    {{$title}}
                </h3>
                <p class="text-xl mt-4">{{$text}}</p>
                <p class="text-xl mt-4">{{$slot}}</p>
                <p class="text-xl mt-4"><a href="#">
                        <x-form.button>Программа курса</x-form.button>
                    </a></p>
            </a>
        </div>
    </div>
</x-panel>



