@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.users.update', $userModel) }}" method="POST">
            @method('PUT')
            @include('admin.users._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
