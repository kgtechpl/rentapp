@extends('layouts.public')

@section('title', $category->name . ' – ' . ($settings['company_name'] ?? ''))
@section('meta_description', Str::limit(strip_tags($category->description ?? 'Przeglądaj sprzęt w kategorii ' . $category->name), 160))
@section('og_image', $category->getFirstMediaUrl('image') ?: asset('images/logo.png'))
@section('meta_keywords', $category->name . ', wynajem sprzętu, wypożyczalnia, ' . strtolower($category->name))

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Sprzęt</a></li>
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center mb-2">
            @if($category->icon)<i class="{{ $category->icon }} fa-2x text-primary me-3"></i>@endif
            <h1 class="fw-bold mb-0">{{ $category->name }}</h1>
        </div>
        @if($category->description)
            <div class="text-muted mb-4">{!! $category->description !!}</div>
        @endif

        <!-- Filter bar -->
        <div class="filter-bar mb-4 d-flex gap-2 flex-wrap">
            <a href="{{ route('categories.show', $category) }}"
               class="btn btn-sm {{ $statusFilter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                Wszystko
            </a>
            <a href="{{ route('categories.show', $category) }}?status=available"
               class="btn btn-sm {{ $statusFilter === 'available' ? 'btn-success' : 'btn-outline-success' }}">
                <i class="fas fa-check-circle me-1"></i>Dostępne
            </a>
            <a href="{{ route('categories.show', $category) }}?status=rented"
               class="btn btn-sm {{ $statusFilter === 'rented' ? 'btn-warning' : 'btn-outline-warning' }}">
                <i class="fas fa-clock me-1"></i>Wynajęte
            </a>
        </div>

        @if($equipment->isEmpty())
            <div class="alert alert-info">Brak sprzętu w tej kategorii.</div>
        @else
        <div class="row g-4">
            @foreach($equipment as $item)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('equipment.show', $item) }}">
                        @if($item->getFirstMediaUrl('images', 'thumb'))
                            <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}"
                                 class="card-img-top" style="height:200px;object-fit:cover;"
                                 alt="{{ $item->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('equipment.show', $item) }}" class="text-dark text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </h5>
                        @if($item->brand)
                            <small class="text-muted mb-1"><i class="fas fa-tag me-1"></i>{{ $item->brand }}</small>
                        @endif
                        <p class="text-primary fw-bold">{{ $item->price_display }}</p>

                        <span class="badge bg-{{ $item->status_badge_class }} mb-3">
                            {{ $item->status_label }}
                            @if($item->status === 'rented' && $item->rented_until)
                                – dostępny od {{ $item->rented_until->format('d.m.Y') }}
                            @endif
                        </span>

                        <div class="mt-auto d-flex gap-2 flex-wrap">
                            @if(!empty($settings['phone']))
                            <a href="tel:{{ $settings['phone'] }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-phone"></i>
                            </a>
                            @endif
                            @if(!empty($settings['whatsapp']))
                            <a href="https://wa.me/{{ $settings['whatsapp'] }}?text=Pytanie o: {{ urlencode($item->name) }}"
                               target="_blank" class="btn btn-whatsapp btn-sm">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            @endif
                            <a href="{{ route('contact.index') }}?equipment_id={{ $item->id }}"
                               class="btn btn-primary btn-sm flex-fill">
                                Zapytaj
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
