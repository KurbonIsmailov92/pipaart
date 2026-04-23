@extends('layouts.admin')

@section('title', 'Edit News Post')
@section('page-title', 'Edit News Post')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.news.update', $newsPost) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.news._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
