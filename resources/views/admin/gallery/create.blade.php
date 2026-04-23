@extends('layouts.admin')

@section('title', 'Create Gallery Item')
@section('page-title', 'Create Gallery Item')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.gallery._form', ['submitLabel' => 'Create item'])
        </form>
    </div>
@endsection
