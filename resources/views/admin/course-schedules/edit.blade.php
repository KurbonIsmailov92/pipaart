@extends('layouts.admin')

@section('title', __('ui.admin.course_schedules'))
@section('page-title', __('ui.admin.course_schedules'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.course-schedules.update', $schedule) }}">
            @method('PUT')
            @include('admin.course-schedules._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
