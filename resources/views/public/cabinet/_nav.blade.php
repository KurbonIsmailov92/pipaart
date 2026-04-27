@php
    $currentLocale = request()->route('locale', app()->getLocale());
@endphp

<div class="mb-6 flex flex-wrap gap-3">
    <a href="{{ route('cabinet.index', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.cabinet.dashboard') }}</a>
    <a href="{{ route('cabinet.courses', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.cabinet.courses') }}</a>
    <a href="{{ route('cabinet.schedule', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.cabinet.schedule') }}</a>
    <a href="{{ route('cabinet.certificates', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.cabinet.certificates') }}</a>
    <a href="{{ route('cabinet.exams', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.cabinet.exams') }}</a>
    <a href="{{ route('cabinet.applications', ['locale' => $currentLocale]) }}" class="pill-link bg-white text-slate-900">{{ __('ui.applications.my_applications') }}</a>
</div>
