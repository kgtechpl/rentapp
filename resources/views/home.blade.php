@extends('layouts.public')

@section('title', ($settings['company_name'] ?? 'Wynajem') . ' – ' . ($settings['hero_title'] ?? 'Wynajem sprzętu'))
@section('meta_description', $settings['hero_subtitle'] ?? '')

@section('content')

<!-- Hero -->
<section class="hero-section text-center">
    <div class="container">
        <h1>{{ $settings['hero_title'] ?? 'Wynajem sprzętu budowlanego i ogrodowego' }}</h1>
        <p class="lead mt-3 mb-4">{{ $settings['hero_subtitle'] ?? '' }}</p>
        <a href="{{ route('categories.index') }}" class="btn btn-warning btn-lg me-3">
            <i class="fas fa-search me-2"></i>Przeglądaj sprzęt
        </a>
        <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-envelope me-2"></i>Napisz do nas
        </a>
    </div>
</section>

<!-- Categories grid -->
@if($categories->count())
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">Kategorie sprzętu</h2>
        <div class="row g-4">
            @foreach($categories as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('categories.show', $cat) }}" class="text-decoration-none">
                    <div class="card category-card h-100 text-center p-3 shadow-sm">
                        @if($cat->getFirstMediaUrl('image', 'thumb'))
                            <img src="{{ $cat->getFirstMediaUrl('image', 'thumb') }}"
                                 class="card-img-top mb-2 rounded"
                                 style="height:120px;object-fit:cover;"
                                 alt="{{ $cat->name }}">
                        @else
                            <div class="category-icon my-3">
                                <i class="{{ $cat->icon ?? 'fas fa-tools' }}"></i>
                            </div>
                        @endif
                        <h6 class="fw-bold text-dark">{{ $cat->name }}</h6>
                        <small class="text-muted">{{ $cat->active_equipment_count }} pozycji</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured equipment -->
@if($featured->count())
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">Polecany sprzęt</h2>
        <div class="row g-4">
            @foreach($featured as $item)
            <div class="col-md-3 col-sm-6">
                <div class="card equipment-card shadow-sm h-100">
                    @if($item->getFirstMediaUrl('images', 'thumb'))
                        <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}"
                             class="card-img-top" alt="{{ $item->name }}">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">{{ $item->name }}</h6>
                        <small class="text-muted mb-2">{{ $item->category->name }}</small>
                        <p class="text-primary fw-bold mt-auto mb-2">{{ $item->price_display }}</p>
                        <span class="badge bg-{{ $item->status_badge_class }} mb-2">
                            {{ $item->status_label }}
                            @if($item->status === 'rented' && $item->rented_until)
                                do {{ $item->rented_until->format('d.m.Y') }}
                            @endif
                        </span>
                        <a href="{{ route('equipment.show', $item) }}" class="btn btn-outline-primary btn-sm mt-auto">
                            Zobacz szczegóły
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-list me-2"></i>Cały katalog sprzętu
            </a>
        </div>
    </div>
</section>
@endif

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">
                    <i class="fas fa-wrench text-primary me-2"></i>Oferujemy również usługi
                </h2>
                <p class="lead">
                    Nie chcesz wynajmować sprzętu? Możemy wykonać pracę za Ciebie!
                    Profesjonalnie, szybko i sprawnie.
                </p>
                <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-right me-2"></i>Sprawdź nasze usługi
                </a>
            </div>
            <div class="col-md-6 text-center">
                <i class="fas fa-hard-hat fa-10x text-muted opacity-25"></i>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
@if(!empty($settings['contact_intro']))
<section class="py-5">
    <div class="container text-center">
        <h3 class="mb-3">{{ $settings['contact_intro'] }}</h3>
        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-paper-plane me-2"></i>Wyślij zapytanie
        </a>
    </div>
</section>
@endif

@endsection
