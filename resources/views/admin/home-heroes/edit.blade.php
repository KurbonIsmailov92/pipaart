@extends('layouts.admin')

@section('title', __('ui.admin.home_heroes'))
@section('page-title', __('ui.admin.home_heroes'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.home-heroes.update', $hero) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="locale" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.common.language') }}</label>
                    <select id="locale" name="locale" class="ui-input">
                        @foreach(config('app.supported_locales', ['ru', 'tg', 'en']) as $locale)
                            <option value="{{ $locale }}" @selected(old('locale', $hero->locale) === $locale)>{{ strtoupper($locale) }}</option>
                        @endforeach
                    </select>
                    @error('locale') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 p-4 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $hero->is_active)) class="rounded border-slate-300">
                    {{ __('ui.common.published') }}
                </label>
            </div>

            <div>
                <label for="title" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.title') }}</label>
                <input id="title" name="title" value="{{ old('title', $hero->title) }}" class="ui-input" required>
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="subtitle" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.description') }}</label>
                <textarea id="subtitle" name="subtitle" rows="4" class="ui-input">{{ old('subtitle', $hero->subtitle) }}</textarea>
                @error('subtitle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="cta_text" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.hero.cta_text') }}</label>
                    <input id="cta_text" name="cta_text" value="{{ old('cta_text', $hero->cta_text) }}" class="ui-input">
                    @error('cta_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="cta_url" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.hero.cta_url') }}</label>
                    <input id="cta_url" name="cta_url" value="{{ old('cta_url', $hero->cta_url) }}" class="ui-input" placeholder="/courses">
                    @error('cta_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ __('ui.common.save') }}</button>
                <a href="{{ route('admin.home-heroes.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.cancel') }}</a>
            </div>
        </form>
    </x-ui.card>
@endsection
