@extends('layouts.admin')

@section('title', __('ui.admin.exam_dates'))
@section('page-title', __('ui.admin.exam_dates'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.exam-dates.update', $exam) }}">
            @method('PUT')
            @include('admin.exam-dates._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
