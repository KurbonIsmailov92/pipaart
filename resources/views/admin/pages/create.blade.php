@extends('layouts.admin')

@section('title', 'Create Page')
@section('page-title', 'Create Page')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.pages.store') }}" method="POST">
            @include('admin.pages._form', ['submitLabel' => 'Create page'])
        </form>
    </div>
@endsection
