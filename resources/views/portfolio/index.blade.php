@extends('layouts.public')
@section('title', 'Nasze realizacje - ' . ($settings['company_name'] ?? ''))
@section('meta_description', 'Zobacz nasze ukończone projekty i realizacje.')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active">Realizacje</li>
            </ol>
        </nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4 text-center"><i class="fas fa-images text-primary me-2"></i>Nasze realizacje</h1>
        @if($items->isEmpty())
            <div class="alert alert-info text-center">Wkrótce dodamy przykłady naszych realizacji.</div>
        @else
        <div class="row g-4">
            @foreach($items as $item)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('portfolio.show', $item) }}">
                        @if($item->getFirstMediaUrl('images', 'thumb'))
                            <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}" class="card-img-top" style="height:250px;object-fit:cover;">
                        @else
                            <div style="height:250px;background:#e9ecef;" class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        @if($item->category)<span class="badge bg-primary mb-2">{{ $item->category }}</span>@endif
                        @if($item->completion_date)
                            <small class="text-muted d-block">{{ $item->completion_date->format('m.Y') }}</small>
                        @endif
                        <a href="{{ route('portfolio.show', $item) }}" class="btn btn-outline-primary btn-sm mt-2">Zobacz więcej</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
