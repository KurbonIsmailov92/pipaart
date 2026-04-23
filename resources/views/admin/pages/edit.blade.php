@extends('layouts.admin')

@section('title', 'Edit Page')
@section('page-title', 'Edit Page')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @method('PUT')
            @include('admin.pages._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
