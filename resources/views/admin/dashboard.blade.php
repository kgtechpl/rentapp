@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content_header')
    <h1><i class="fas fa-tachometer-alt mr-2"></i>Panel główny</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['available'] }}</h3>
                <p>Sprzęt dostępny</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('admin.equipment.index') }}?status=available" class="small-box-footer">
                Zobacz <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['rented'] }}</h3>
                <p>Sprzęt wynajęty</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="{{ route('admin.equipment.index') }}?status=rented" class="small-box-footer">
                Zobacz <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $stats['hidden'] }}</h3>
                <p>Ukryty sprzęt</p>
            </div>
            <div class="icon"><i class="fas fa-eye-slash"></i></div>
            <a href="{{ route('admin.equipment.index') }}?status=hidden" class="small-box-footer">
                Zobacz <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['new_inquiries'] }}</h3>
                <p>Nowe zapytania</p>
            </div>
            <div class="icon"><i class="fas fa-envelope"></i></div>
            <a href="{{ route('admin.inquiries.index') }}?status=new" class="small-box-footer">
                Zobacz <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tools mr-2"></i>Ostatnio dodany sprzęt</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Dodaj
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                    @forelse($recentEquipment as $item)
                        <tr>
                            <td>
                                <a href="{{ route('admin.equipment.edit', $item) }}">{{ $item->name }}</a>
                                <small class="text-muted d-block">{{ $item->category->name }}</small>
                            </td>
                            <td class="text-right">
                                <span class="badge badge-{{ $item->status_badge_class }}">{{ $item->status_label }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted p-3">Brak sprzętu</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.equipment.index') }}" class="btn btn-sm btn-outline-primary">Cały sprzęt →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-envelope mr-2"></i>Ostatnie zapytania</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                    @forelse($recentInquiries as $inq)
                        <tr>
                            <td>
                                <a href="{{ route('admin.inquiries.show', $inq) }}">{{ $inq->name }}</a>
                                @if($inq->equipment)
                                    <small class="text-muted d-block">{{ $inq->equipment->name }}</small>
                                @endif
                            </td>
                            <td class="text-right">
                                <span class="badge badge-{{ $inq->status_badge_class }}">{{ $inq->status_label }}</span>
                                <small class="d-block text-muted">{{ $inq->created_at->diffForHumans() }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted p-3">Brak zapytań</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-danger">Wszystkie zapytania →</a>
            </div>
        </div>
    </div>
</div>
@stop
