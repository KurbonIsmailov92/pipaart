@extends('layouts.admin')

@section('title', __('ui.admin.create_exam_date'))
@section('page-title', __('ui.admin.create_exam_date'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.exam-dates.store') }}">
            @include('admin.exam-dates._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
