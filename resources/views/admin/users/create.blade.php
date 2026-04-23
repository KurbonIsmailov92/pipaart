@extends('layouts.admin')

@section('title', 'Create User')
@section('page-title', 'Create User')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @include('admin.users._form', ['submitLabel' => 'Create user'])
        </form>
    </div>
@endsection
