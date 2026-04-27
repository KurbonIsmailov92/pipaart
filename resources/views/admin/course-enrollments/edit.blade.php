@extends('layouts.admin')

@section('title', __('ui.admin.enrollments'))
@section('page-title', __('ui.admin.enrollments'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.course-enrollments.update', $enrollment) }}">
            @method('PUT')
            @include('admin.course-enrollments._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
