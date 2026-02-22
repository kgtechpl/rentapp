@extends('adminlte::page')

@section('title', 'Zapytania')
@section('content_header')
    <h1><i class="fas fa-envelope mr-2"></i>Zapytania od klientów</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <i class="fas fa-check mr-2"></i>{{ session('success') }}
</div>
@endif

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request('status') ? 'active' : '' }}"
           href="{{ route('admin.inquiries.index') }}">Wszystkie</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'new' ? 'active' : '' }}"
           href="{{ route('admin.inquiries.index') }}?status=new">
            Nowe <span class="badge badge-danger">{{ \App\Models\ContactInquiry::where('status','new')->count() }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'read' ? 'active' : '' }}"
           href="{{ route('admin.inquiries.index') }}?status=read">Przeczytane</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'replied' ? 'active' : '' }}"
           href="{{ route('admin.inquiries.index') }}?status=replied">Odpowiedziano</a>
    </li>
</ul>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Data</th>
                    <th>Klient</th>
                    <th>Sprzęt</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
            @forelse($inquiries as $inq)
                <tr class="{{ $inq->status === 'new' ? 'table-warning' : '' }}">
                    <td>
                        <strong>{{ $inq->created_at->format('d.m.Y') }}</strong>
                        <small class="d-block text-muted">{{ $inq->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <strong>{{ $inq->name }}</strong>
                        <small class="d-block">
                            <a href="mailto:{{ $inq->email }}">{{ $inq->email }}</a>
                        </small>
                        @if($inq->phone)
                            <small class="d-block"><a href="tel:{{ $inq->phone }}">{{ $inq->phone }}</a></small>
                        @endif
                    </td>
                    <td>{{ $inq->equipment?->name ?? '—' }}</td>
                    <td><span class="badge badge-{{ $inq->status_badge_class }}">{{ $inq->status_label }}</span></td>
                    <td>
                        <a href="{{ route('admin.inquiries.show', $inq) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Otwórz
                        </a>
                        <a href="mailto:{{ $inq->email }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-reply"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted p-4">Brak zapytań</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($inquiries->hasPages())
    <div class="card-footer">
        {{ $inquiries->links() }}
    </div>
    @endif
</div>
@stop
