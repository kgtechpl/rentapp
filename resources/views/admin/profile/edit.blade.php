@extends('adminlte::page')

@section('title', 'Mój profil')

@section('content_header')
    <h1><i class="fas fa-user-circle mr-2"></i>Mój profil</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Dane osobowe</h3>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST">
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
                        <label for="current_password">Aktualne hasło</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

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
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-user-img img-fluid img-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <span class="text-white" style="font-size: 48px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->email }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Konto utworzone</b>
                        <span class="float-right">{{ $user->created_at->format('d.m.Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Ostatnia aktualizacja</b>
                        <span class="float-right">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop
