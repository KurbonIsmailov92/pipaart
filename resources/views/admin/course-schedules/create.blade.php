@extends('layouts.admin')

@section('title', __('ui.admin.create_course_schedule'))
@section('page-title', __('ui.admin.create_course_schedule'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.course-schedules.store') }}">
            @include('admin.course-schedules._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
