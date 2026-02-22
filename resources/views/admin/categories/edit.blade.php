@extends('adminlte::page')

@section('title', 'Edytuj: ' . $category->name)
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-edit me-2"></i>Edytuj: {{ $category->name }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Powrót
        </a>
    </div>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check me-2"></i>{{ session('success') }}</div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('admin.categories._form')
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Zapisz zmiany
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
