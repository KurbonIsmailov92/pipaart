@extends('layouts.admin')

@section('title', __('ui.admin.create_enrollment'))
@section('page-title', __('ui.admin.create_enrollment'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.course-enrollments.store') }}">
            @include('admin.course-enrollments._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
