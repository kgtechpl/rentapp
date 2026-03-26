@extends('layouts.public')

@section('title', $servicePage->title . ' - ' . ($settings['company_name'] ?? 'Wynajem sprzętu'))
@section('meta_description', strip_tags(Str::limit($servicePage->content, 160)))

@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $servicePage->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Service Content -->
<div class="py-5">
    <div class="container">
        <h1 class="mb-4">{{ $servicePage->title }}</h1>
        <div class="content">
            {!! $servicePage->content !!}
        </div>

        <!-- CTA -->
        <div class="mt-5 p-4 bg-light rounded">
            <h4>Zainteresowany naszymi usługami?</h4>
            <p class="mb-3">Skontaktuj się z nami, aby omówić szczegóły i uzyskać wycenę.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope me-2"></i>Wyślij zapytanie
            </a>
        </div>
    </div>
</div>

<!-- Equipment for services -->
@if($serviceEquipment->count())
<div class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">
            <i class="fas fa-wrench text-warning me-2"></i>Sprzęt, którym świadczymy usługi
        </h3>
        <div class="position-relative">
            <div class="equipment-scroll-container">
                @foreach($serviceEquipment as $item)
                <div class="equipment-scroll-item">
                    <a href="{{ route('equipment.show', $item) }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            @if($item->getFirstMediaUrl('images', 'thumb'))
                                <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}"
                                     class="card-img-top"
                                     style="height:150px;object-fit:cover;"
                                     alt="{{ $item->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height:150px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-dark mb-1">{{ $item->name }}</h6>
                                <small class="text-muted d-block mb-2">{{ $item->categories->first()?->name ?? 'Bez kategorii' }}</small>
                                <span class="badge bg-{{ $item->status_badge_class }}">{{ $item->status_label }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
.equipment-scroll-container {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding: 0.5rem 0 1rem 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

.equipment-scroll-container::-webkit-scrollbar {
    height: 8px;
}

.equipment-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.equipment-scroll-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.equipment-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.equipment-scroll-item {
    flex: 0 0 250px;
    min-width: 250px;
}

@media (max-width: 576px) {
    .equipment-scroll-item {
        flex: 0 0 200px;
        min-width: 200px;
    }
}
</style>
@endpush

@endsection
