@extends('adminlte::page')

@section('title', 'Sprzęt')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-tools mr-2"></i>Sprzęt</h1>
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>Dodaj sprzęt
        </a>
    </div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <i class="fas fa-check mr-2"></i>{{ session('success') }}
</div>
@endif

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="form-row align-items-end">
            <div class="col-md-3">
                <label class="small">Kategoria</label>
                <select name="category_id" class="form-control form-control-sm">
                    <option value="">Wszystkie kategorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="small">Status</label>
                <select name="status" class="form-control form-control-sm">
                    <option value="">Wszystkie</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Dostępny</option>
                    <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Wynajęty</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Ukryty</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small">Szukaj</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Nazwa sprzętu..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search mr-1"></i>Filtruj
                </button>
                <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Zdjęcie</th>
                    <th>Nazwa</th>
                    <th>Kategoria</th>
                    <th>Cena/dzień</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
            @forelse($equipment as $item)
                <tr>
                    <td>
                        @if($item->getFirstMediaUrl('images', 'thumb'))
                            <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}"
                                 style="width:60px;height:45px;object-fit:cover;border-radius:4px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="width:60px;height:45px;border-radius:4px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($item->brand)<small class="d-block text-muted">{{ $item->brand }}</small>@endif
                        @if($item->is_featured)<span class="badge badge-warning">Polecany</span>@endif
                    </td>
                    <td>
                        @foreach($item->categories as $cat)
                            <span class="badge badge-primary">{{ $cat->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $item->price_display }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status_badge_class }}">{{ $item->status_label }}</span>
                        @if($item->status === 'rented' && $item->rented_until)
                            <small class="d-block text-muted">do {{ $item->rented_until->format('d.m.Y') }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.equipment.edit', $item) }}" class="btn btn-outline-primary" title="Edytuj">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.equipment.toggle-visibility', $item) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-{{ $item->status === 'hidden' ? 'success' : 'secondary' }}"
                                        title="{{ $item->status === 'hidden' ? 'Pokaż' : 'Ukryj' }}">
                                    <i class="fas fa-{{ $item->status === 'hidden' ? 'eye' : 'eye-slash' }}"></i>
                                </button>
                            </form>

                            @if($item->status !== 'available')
                            <form action="{{ route('admin.equipment.mark-available', $item) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success" title="Oznacz jako dostępny">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif

                            <button class="btn btn-sm btn-outline-warning"
                                    data-toggle="modal"
                                    data-target="#rentedModal{{ $item->id }}"
                                    title="Oznacz jako wynajęty">
                                <i class="fas fa-clock"></i>
                            </button>

                            <form action="{{ route('admin.equipment.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Usunąć {{ addslashes($item->name) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Usuń">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Rented until modal (Bootstrap 4) -->
                <div class="modal fade" id="rentedModal{{ $item->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Wynajęty do kiedy?</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <form action="{{ route('admin.equipment.mark-rented', $item) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="modal-body">
                                    <p class="small text-muted mb-2">{{ $item->name }}</p>
                                    <label class="form-label">Data zwrotu</label>
                                    <input type="date" name="rented_until" class="form-control"
                                           value="{{ $item->rented_until?->format('Y-m-d') ?? date('Y-m-d', strtotime('+7 days')) }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-clock mr-1"></i>Oznacz wynajęty
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr><td colspan="6" class="text-center text-muted p-4">Brak sprzętu. <a href="{{ route('admin.equipment.create') }}">Dodaj pierwszy</a>.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($equipment->hasPages())
    <div class="card-footer">
        {{ $equipment->links() }}
    </div>
    @endif
</div>
@stop
