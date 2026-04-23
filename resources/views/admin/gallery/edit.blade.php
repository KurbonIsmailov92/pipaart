@extends('layouts.admin')

@section('title', 'Edit Gallery Item')
@section('page-title', 'Edit Gallery Item')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('admin.gallery.update', $photo) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.gallery._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection
