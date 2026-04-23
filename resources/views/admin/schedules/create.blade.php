@extends('layouts.admin')

@section('title', 'Create Schedule')
@section('page-title', 'Create Schedule')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @include('admin.schedules._form', ['submitLabel' => 'Create schedule entry'])
        </form>
    </div>
@endsection
