@extends('layouts.admin')

@section('title', 'Create Course')
@section('page-title', 'Create Course')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.courses._form', ['submitLabel' => 'Create course'])
        </form>
    </div>
@endsection
