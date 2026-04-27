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
                <x-ui.button-link :href="route('courses.schedule', ['locale' => $currentLocale])" variant="secondary">{{ __('ui.home.view_schedule') }}</x-ui.button-link>
            </div>
        </x-ui.card>

        <div class="grid gap-6">
            <x-ui.card class="overflow-hidden p-0">
                <img
                    src="{{ $course->image_url ?: $fallbackImage }}"
                    alt="{{ $course->title }}"
                    class="h-full min-h-[22rem] w-full object-cover"
                >
            </x-ui.card>

            <x-ui.card>
                <p class="ui-kicker">{{ __('ui.applications.title') }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ __('ui.applications.apply_title') }}</h2>

                @auth
                    @unless(auth()->user()->isStudent())
                        <p class="mt-3 text-sm text-slate-600">{{ __('ui.applications.student_only') }}</p>
                    @else
                    @if($currentApplication)
                        <p class="mt-3 text-sm text-slate-600">
                            {{ __('ui.applications.already_applied') }}
                            <span class="font-semibold text-slate-950">{{ __('ui.applications.statuses.'.$currentApplication->status) }}</span>
                        </p>
                        <div class="mt-5">
                            <x-ui.button-link :href="route('cabinet.applications', ['locale' => $currentLocale])" variant="secondary">
                                {{ __('ui.applications.view_my_applications') }}
                            </x-ui.button-link>
                        </div>
                    @else
                        <form method="POST" action="{{ route('courses.applications.store', ['locale' => $currentLocale, 'course' => $course]) }}" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label for="comment" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.applications.comment') }}</label>
                                <textarea id="comment" name="comment" rows="4" class="ui-input" placeholder="{{ __('ui.applications.comment_placeholder') }}">{{ old('comment') }}</textarea>
                                @error('comment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="ui-button ui-button-primary">{{ __('ui.applications.apply') }}</button>
                        </form>
                    @endif
                    @endunless
                @else
                    <p class="mt-3 text-sm text-slate-600">{{ __('ui.applications.login_prompt') }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <x-ui.button-link :href="route('auth.login')">{{ __('ui.common.login') }}</x-ui.button-link>
                        <x-ui.button-link :href="route('auth.register')" variant="secondary">{{ __('ui.common.register') }}</x-ui.button-link>
                    </div>
                @endauth
            </x-ui.card>
        </div>
    </div>
@endsection
