@extends('adminlte::page')

@section('title', 'Dodaj sprzęt')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-plus me-2"></i>Dodaj sprzęt</h1>
        <a href="{{ route('admin.equipment.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Powrót
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.equipment._form')

            <div class="mb-4">
                <label class="form-label fw-bold">Zdjęcia (można dodać więcej po zapisaniu)</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">Możesz wybrać wiele plików. Max 4MB każdy.</small>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Zapisz i przejdź do edycji
            </button>
        </form>
    </div>
</div>
@stop
