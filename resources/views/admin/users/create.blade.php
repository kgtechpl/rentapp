@extends('adminlte::page')

@section('title', 'Dodaj administratora')

@section('content_header')
    <h1><i class="fas fa-user-plus mr-2"></i>Dodaj administratora</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Imię i nazwisko *</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Hasło *</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                <small class="form-text text-muted">Minimum 8 znaków</small>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Potwierdź hasło *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Dodaj administratora
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Anuluj
            </a>
        </div>
    </form>
</div>
@stop
