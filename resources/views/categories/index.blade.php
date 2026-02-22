@extends('layouts.public')

@section('title', 'Sprzęt do wynajęcia – ' . ($settings['company_name'] ?? ''))
@section('meta_description', 'Przeglądaj wszystkie kategorie sprzętu dostępnego do wynajęcia.')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active">Sprzęt</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Sprzęt do wynajęcia</h1>

        @if($categories->isEmpty())
            <div class="alert alert-info">Brak kategorii. Sprawdź wkrótce!</div>
        @else
        <div class="row g-4">
            @foreach($categories as $cat)
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('categories.show', $cat) }}" class="text-decoration-none">
                    <div class="card category-card h-100 shadow-sm">
                        @if($cat->getFirstMediaUrl('image', 'thumb'))
                            <img src="{{ $cat->getFirstMediaUrl('image', 'thumb') }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;"
                                 alt="{{ $cat->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                                <i class="{{ $cat->icon ?? 'fas fa-tools' }} fa-3x text-primary"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-dark">
                                @if($cat->icon)<i class="{{ $cat->icon }} me-2 text-primary"></i>@endif
                                {{ $cat->name }}
                            </h5>
                            @if($cat->description)
                            <p class="card-text text-muted small">{{ Str::limit($cat->description, 100) }}</p>
                            @endif
                            <span class="badge bg-primary">{{ $cat->active_equipment_count }} pozycji</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
