@extends('adminlte::page')

@section('title', 'Edytuj administratora')

@section('content_header')
    <h1><i class="fas fa-user-edit mr-2"></i>Edytuj administratora</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Imię i nazwisko *</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>
            <h5 class="mb-3"><i class="fas fa-key mr-2"></i>Zmiana hasła (opcjonalnie)</h5>
            <p class="text-muted">Pozostaw puste, jeśli nie chcesz zmieniać hasła</p>

            <div class="form-group">
                <label for="password">Nowe hasło</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                <small class="form-text text-muted">Minimum 8 znaków</small>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Potwierdź nowe hasło</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Zapisz zmiany
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Anuluj
            </a>
        </div>
    </form>
</div>
@stop
