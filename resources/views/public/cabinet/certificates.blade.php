@extends('layouts.app')

@section('title', __('ui.cabinet.certificates'))

@section('content')
    <x-ui.page-header :title="__('ui.cabinet.certificates')" :description="__('ui.cabinet.certificates_description')" :eyebrow="__('ui.cabinet.title')" />

    @include('public.cabinet._nav')

    <div class="grid gap-4">
        @forelse($certificates as $certificate)
            <x-ui.card>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="ui-kicker">{{ $certificate->status }}</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $certificate->title }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ $certificate->course?->title }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ __('ui.cabinet.certificate_number') }}: {{ $certificate->certificate_number ?: '-' }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ __('ui.cabinet.issued_at') }}: {{ $certificate->issued_at?->format('Y-m-d') ?: '-' }}</p>
                    </div>
                    @if($certificate->file_path)
                        <x-ui.button-link :href="route('cabinet.certificates.download', ['locale' => request()->route('locale'), 'certificate' => $certificate])" variant="secondary">
                            {{ __('ui.cabinet.download_certificate') }}
                        </x-ui.button-link>
                    @endif
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-600">{{ __('ui.cabinet.no_certificates') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-6">{{ $certificates->links() }}</div>
@endsection
