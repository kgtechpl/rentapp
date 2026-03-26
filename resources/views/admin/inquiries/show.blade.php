@extends('adminlte::page')

@section('title', 'Zapytanie #' . $inquiry->id)
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-envelope-open mr-2"></i>Zapytanie #{{ $inquiry->id }}</h1>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Powrót
        </a>
    </div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Treść zapytania</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Data</dt>
                    <dd class="col-sm-9">{{ $inquiry->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-3">Imię i nazwisko</dt>
                    <dd class="col-sm-9">{{ $inquiry->name }}</dd>

                    <dt class="col-sm-3">E-mail</dt>
                    <dd class="col-sm-9">
                        <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>
                    </dd>

                    @if($inquiry->phone)
                    <dt class="col-sm-3">Telefon</dt>
                    <dd class="col-sm-9">
                        <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                    </dd>
                    @endif

                    @if($inquiry->equipment)
                    <dt class="col-sm-3">Sprzęt</dt>
                    <dd class="col-sm-9">
                        <a href="{{ route('admin.equipment.edit', $inquiry->equipment) }}">
                            {{ $inquiry->equipment->name }}
                        </a>
                        ({{ $inquiry->equipment->categories->first()?->name ?? 'Bez kategorii' }})
                    </dd>
                    @endif

                    @if($inquiry->rental_date_from)
                    <dt class="col-sm-3">Wynajem od</dt>
                    <dd class="col-sm-9">{{ $inquiry->rental_date_from->format('d.m.Y') }}</dd>
                    @endif

                    @if($inquiry->rental_date_to)
                    <dt class="col-sm-3">Wynajem do</dt>
                    <dd class="col-sm-9">{{ $inquiry->rental_date_to->format('d.m.Y') }}</dd>
                    @endif

                    <dt class="col-sm-3">IP</dt>
                    <dd class="col-sm-9 text-muted small">{{ $inquiry->ip_address }}</dd>
                </dl>

                <hr>
                <h6 class="font-weight-bold">Wiadomość:</h6>
                <div class="bg-light p-3 rounded" style="white-space: pre-wrap;">{{ $inquiry->message }}</div>

                <div class="mt-4">
                    <a href="mailto:{{ $inquiry->email }}?subject=Re: Zapytanie o {{ $inquiry->equipment?->name ?? 'sprzęt' }}"
                       class="btn btn-primary mr-2">
                        <i class="fas fa-reply mr-2"></i>Odpowiedz e-mailem
                    </a>
                    @if($inquiry->phone)
                    <a href="tel:{{ $inquiry->phone }}" class="btn btn-outline-primary">
                        <i class="fas fa-phone mr-2"></i>Zadzwoń
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Zmień status</h5>
            </div>
            <div class="card-body">
                <p>Aktualny: <span class="badge badge-{{ $inquiry->status_badge_class }}">{{ $inquiry->status_label }}</span></p>

                <form action="{{ route('admin.inquiries.update-status', $inquiry) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>Nowe</option>
                            <option value="read" {{ $inquiry->status === 'read' ? 'selected' : '' }}>Przeczytane</option>
                            <option value="replied" {{ $inquiry->status === 'replied' ? 'selected' : '' }}>Odpowiedziano</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Zapisz status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
