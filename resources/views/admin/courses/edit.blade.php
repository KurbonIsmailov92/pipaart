@extends('layouts.admin')

@section('title', 'Edit Course')
@section('page-title', 'Edit Course')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.courses._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
