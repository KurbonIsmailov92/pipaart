@extends('layouts.admin')

@section('title', 'Edit Schedule')
@section('page-title', 'Edit Schedule')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @method('PUT')
            @include('admin.schedules._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
