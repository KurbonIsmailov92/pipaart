@extends('layouts.admin')

@section('title', __('ui.admin.certificates'))
@section('page-title', __('ui.admin.certificates'))

@section('content')
    <x-ui.card>
        <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.certificates._form', ['submitLabel' => __('ui.common.save')])
        </form>
    </x-ui.card>
@endsection
