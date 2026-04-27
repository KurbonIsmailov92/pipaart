@extends('layouts.admin')

@section('title', __('ui.admin.home_heroes'))
@section('page-title', __('ui.admin.home_heroes'))

@section('content')
    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">{{ __('ui.common.language') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.title') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.description') }}</th>
                <th class="px-4 py-3">{{ __('ui.common.status') }}</th>
                <th class="px-4 py-3 text-right">{{ __('ui.common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @foreach($heroes as $hero)
                <tr>
                    <td class="px-4 py-3">{{ strtoupper($hero->locale) }}</td>
                    <td class="px-4 py-3 font-medium">{{ $hero->title }}</td>
                    <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit((string) $hero->subtitle, 90) }}</td>
                    <td class="px-4 py-3">{{ $hero->is_active ? __('ui.common.published') : __('ui.common.draft') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.home-heroes.edit', $hero) }}" class="text-blue-600">{{ __('ui.common.edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
