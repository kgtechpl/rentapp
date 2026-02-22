@extends('adminlte::page')
@section('title', 'Realizacje')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-images me-2"></i>Realizacje</h1>
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Dodaj realizację
        </a>
    </div>
@stop
@section('content')
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        @forelse($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($item->getFirstMediaUrl('images', 'thumb'))
                    <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}" class="card-img-top" style="height:200px;object-fit:cover;">
                @else
                    <div style="height:200px;background:#e9ecef;" class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    @if($item->category)<small class="badge badge-info">{{ $item->category }}</small>@endif
                    <span class="badge badge-{{ $item->is_active ? 'success' : 'secondary' }} ml-1">
                        {{ $item->is_active ? 'Aktywne' : 'Ukryte' }}
                    </span>
                    <div class="mt-2">
                        <a href="{{ route('admin.portfolio.edit', $item) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Edytuj
                        </a>
                        <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Usunąć?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12"><p class="text-center text-muted">Brak realizacji</p></div>
        @endforelse
    </div>
@stop
