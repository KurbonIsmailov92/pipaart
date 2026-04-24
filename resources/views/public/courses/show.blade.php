@extends('layouts.app')

@section('title', $course->title)

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
        $fallbackImage = \Illuminate\Support\Facades\Vite::asset('resources/images/cipa.jpg');
    @endphp

    <x-ui.page-header
        :title="$course->title"
        :description="$course->duration_label . ((float) $course->price > 0 ? ' • ' . number_format((float) $course->price, 2) : '')"
        :eyebrow="__('ui.nav.courses')"
    >
        <x-slot:actions>
            <x-ui.button-link :href="route('courses.index', ['locale' => $currentLocale])" variant="secondary">{{ __('ui.common.back_to_courses') }}</x-ui.button-link>
            @can('update', $course)
                <x-ui.button-link :href="route('admin.courses.edit', $course)" variant="ghost">{{ __('ui.common.edit_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr]">
        <x-ui.card>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.6rem] bg-[#edf4f6] p-5">
                    <p class="ui-kicker">{{ __('ui.forms.duration') }}</p>
                    <p class="mt-2 text-lg font-semibold text-slate-950">{{ $course->duration_label }}</p>
                </div>
                <div class="rounded-[1.6rem] bg-[#f4efe5] p-5">
                    <p class="ui-kicker">{{ __('ui.forms.price') }}</p>
                    <p class="mt-2 text-lg font-semibold text-slate-950">
                        {{ (float) $course->price > 0 ? number_format((float) $course->price, 2) : __('ui.courses.duration_on_request') }}
                    </p>
                </div>
            </div>

            <div class="ui-prose mt-6">
                <p>{{ $course->description }}</p>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <x-ui.button-link :href="route('contacts.message', ['locale' => $currentLocale])">{{ __('ui.contact.open_form') }}</x-ui.button-link>
                <x-ui.button-link :href="route('schedule.index', ['locale' => $currentLocale])" variant="secondary">{{ __('ui.home.view_schedule') }}</x-ui.button-link>
            </div>
        </x-ui.card>

        <x-ui.card class="overflow-hidden p-0">
            <img
                src="{{ $course->image ? \Illuminate\Support\Facades\Storage::url($course->image) : $fallbackImage }}"
                alt="{{ $course->title }}"
                class="h-full min-h-[22rem] w-full object-cover"
            >
        </x-ui.card>
    </div>
@endsection
