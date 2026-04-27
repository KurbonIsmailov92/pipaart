@extends('layouts.admin')

@section('title', __('ui.admin.create_certificate'))
@section('page-title', __('ui.admin.create_certificate'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data">
            @include('admin.certificates._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
