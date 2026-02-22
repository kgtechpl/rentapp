@extends('adminlte::page')

@section('title', 'Kategorie')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-tags mr-2"></i>Kategorie</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>Dodaj kategorię
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

@if($errors->has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    {{ $errors->first('error') }}
</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Obraz</th>
                    <th>Nazwa</th>
                    <th>Ikona</th>
                    <th>Kolejność</th>
                    <th>Sprzęt</th>
                    <th>Aktywna</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $cat)
                <tr>
                    <td>
                        @if($cat->getFirstMediaUrl('image', 'thumb'))
                            <img src="{{ $cat->getFirstMediaUrl('image', 'thumb') }}"
                                 style="width:60px;height:45px;object-fit:cover;border-radius:4px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="width:60px;height:45px;border-radius:4px;">
                                <i class="{{ $cat->icon ?? 'fas fa-tools' }} text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $cat->name }}</strong>
                        <small class="d-block text-muted">{{ $cat->slug }}</small>
                    </td>
                    <td><i class="{{ $cat->icon ?? '' }}"></i> <code>{{ $cat->icon }}</code></td>
                    <td>{{ $cat->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.equipment.index') }}?category_id={{ $cat->id }}">
                            {{ $cat->equipment_count }}
                        </a>
                    </td>
                    <td>
                        @if($cat->is_active)
                            <span class="badge badge-success">Aktywna</span>
                        @else
                            <span class="badge badge-secondary">Nieaktywna</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Usunąć kategorię {{ addslashes($cat->name) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted p-4">Brak kategorii. <a href="{{ route('admin.categories.create') }}">Dodaj pierwszą</a>.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
