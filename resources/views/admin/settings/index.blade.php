@extends('layouts.admin')

@section('title', 'Site Settings')
@section('page-title', 'Settings')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6">
                @foreach($settings as $setting)
                    <div>
                        <label for="settings_{{ $setting->key }}" class="mb-2 block text-sm font-medium text-slate-700">{{ str($setting->key)->replace('_', ' ')->title() }}</label>
                        <textarea id="settings_{{ $setting->key }}" name="settings[{{ $setting->key }}]" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Save settings</button>
            </div>
        </form>
    </div>
@endsection
