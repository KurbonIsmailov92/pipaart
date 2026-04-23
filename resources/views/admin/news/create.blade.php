@extends('layouts.admin')

@section('title', 'Create News Post')
@section('page-title', 'Create News Post')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.news._form', ['submitLabel' => 'Create post'])
        </form>
    </div>
@endsection
