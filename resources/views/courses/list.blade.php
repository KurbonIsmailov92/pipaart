@extends('layouts.app')

@section('title', 'Перечень курсов')

@section('content')
    <div class="flex items-center justify-between w-full mb-8">
        <h1 class="mt-6 text-primary text-2xl sm:text-4xl text-center">Перечень курсов</h1>
        @if(auth()->check() && auth()->user()->isAdmin())
            <x-form.button class="ml-4"> <a href="/courses/create">Добавить</a></x-form.button>
        @endif
    </div>



    <div class="text-sm sm:text-base mt-6 space-y-6">
        @foreach($courses as $course)
            <x-course-item title="{{$course['title']}}"
                           text="{{$course['description']}}"
                           argc="{{ route('courses.show', $course->id) }}">
                Продолжительность курса {{$course['hours']}} часов
            </x-course-item>
        @endforeach


        <p><i><b>Примечание: &nbsp;&nbsp; </b></i>По оканчания курсов &quot;Бухгалтерский учет для начинающих&quot;&nbsp;
            и &nbsp; &quot;1С: Предприятие&quot;&nbsp; проводится экзамен, в случаи успешной сдачи (проходной балл
            75)&nbsp; выдается&nbsp; <a href="/web/20180901023031/http://pipaa.tj/ru/index/index/pageId/72/"><i>&quot;Сертификат
                    о профессиональном образовании&quot;</i></a>. На курсы &quot;Финансовый учет - 1&quot; , &quot;Управленческий
            учет - 1&quot; и &quot;Налоги и право&quot; выдается <a
                href="/web/20180901023031/http://pipaa.tj/ru/index/index/pageId/73/"><i>&quot;Письмо о прослушивание
                    курса&quot;</i></a>.</p>
    </div>

@endsection
