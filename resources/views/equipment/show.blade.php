@extends('layouts.public')

@section('title', $equipment->name . ' – ' . ($settings['company_name'] ?? ''))
@section('meta_description', Str::limit(strip_tags($equipment->description ?? $equipment->name), 160))
@section('og_type', 'product')
@section('og_image', $equipment->getFirstMediaUrl('images') ?: asset('images/logo.png'))
@section('meta_keywords', $equipment->category->name . ', ' . ($equipment->brand ?? 'wynajem') . ', wynajem sprzętu, ' . $equipment->name)

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Sprzęt</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.show', $equipment->category) }}">{{ $equipment->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $equipment->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Gallery -->
            <div class="col-md-6">
                @php $images = $equipment->getMedia('images'); @endphp
                @if($images->count())
                    <!-- Main image -->
                    <a href="{{ $images->first()->getUrl() }}" class="glightbox" data-gallery="equipment">
                        <img src="{{ $images->first()->getUrl('medium') }}"
                             class="img-fluid rounded shadow mb-3 w-100"
                             style="max-height:400px;object-fit:cover;"
                             alt="{{ $equipment->name }}">
                    </a>
                    <!-- Thumbnails -->
                    @if($images->count() > 1)
                    <div class="row g-2">
                        @foreach($images->skip(1) as $img)
                        <div class="col-3">
                            <a href="{{ $img->getUrl() }}" class="glightbox" data-gallery="equipment">
                                <img src="{{ $img->getUrl('thumb') }}"
                                     class="img-fluid rounded"
                                     style="height:80px;width:100%;object-fit:cover;"
                                     alt="{{ $equipment->name }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:350px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="col-md-6">
                <h1 class="fw-bold">{{ $equipment->name }}</h1>
                <p class="text-muted mb-1">
                    <i class="fas fa-tag me-1"></i>
                    <a href="{{ route('categories.show', $equipment->category) }}" class="text-decoration-none">
                        {{ $equipment->category->name }}
                    </a>
                </p>
                @if($equipment->brand)
                    <p class="text-muted mb-2"><i class="fas fa-industry me-1"></i>Marka: <strong>{{ $equipment->brand }}</strong></p>
                @endif

                <!-- Status -->
                <div class="mb-3">
                    <span class="badge bg-{{ $equipment->status_badge_class }} fs-6 px-3 py-2">
                        {{ $equipment->status_label }}
                        @if($equipment->status === 'rented' && $equipment->rented_until)
                            – dostępny od {{ $equipment->rented_until->format('d.m.Y') }}
                        @endif
                    </span>
                </div>

                <!-- Availability Calendar -->
                @if($equipment->status === 'rented' && $equipment->rented_until)
                <div class="alert alert-info mb-4">
                    <h6 class="fw-bold"><i class="fas fa-calendar-alt me-2"></i>Dostępność</h6>
                    <p class="mb-0">Ten sprzęt jest aktualnie wynajęty do <strong>{{ $equipment->rented_until->format('d.m.Y') }}</strong></p>
                    <p class="mb-0 small text-muted">Będzie dostępny ponownie: {{ $equipment->rented_until->addDay()->format('d.m.Y') }}</p>
                    @php
                        $daysUntilAvailable = now()->diffInDays($equipment->rented_until, false);
                    @endphp
                    @if($daysUntilAvailable > 0)
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar bg-warning" style="width: {{ min(100, ($daysUntilAvailable / 30) * 100) }}%">
                                Jeszcze {{ $daysUntilAvailable }} dni
                            </div>
                        </div>
                    @endif
                </div>
                @else
                <div class="alert alert-success mb-4">
                    <h6 class="fw-bold"><i class="fas fa-check-circle me-2"></i>Dostępność</h6>
                    <p class="mb-0">Ten sprzęt jest <strong>dostępny od zaraz</strong>! Skontaktuj się z nami aby zarezerwować termin.</p>
                </div>
                @endif

                <!-- Price -->
                <div class="bg-primary bg-opacity-10 rounded p-3 mb-4">
                    <h4 class="text-primary fw-bold mb-0">{{ $equipment->price_display }}</h4>
                </div>

                <!-- Description -->
                @if($equipment->description)
                <div class="mb-4">
                    <h5 class="fw-bold">Opis</h5>
                    <div class="text-muted">{!! $equipment->description !!}</div>
                </div>
                @endif

                @if($equipment->condition_notes)
                <div class="mb-4">
                    <h5 class="fw-bold">Stan techniczny</h5>
                    <p class="text-muted">{{ $equipment->condition_notes }}</p>
                </div>
                @endif

                <!-- Action buttons -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @if(!empty($settings['phone']))
                    <a href="tel:{{ $settings['phone'] }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Zadzwoń
                    </a>
                    @endif
                    @if(!empty($settings['whatsapp']))
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode('Dzień dobry, pytanie o: ' . $equipment->name) }}"
                       target="_blank" class="btn btn-whatsapp btn-lg">
                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                    </a>
                    @endif
                    @if(!empty($settings['email']))
                    <a href="mailto:{{ $settings['email'] }}?subject={{ urlencode('Zapytanie: ' . $equipment->name) }}"
                       class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-envelope me-2"></i>E-mail
                    </a>
                    @endif
                </div>

                <a href="#contact-form" class="btn btn-primary w-100 btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>Wyślij zapytanie online
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact form pre-filled -->
<section id="contact-form" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h3 class="fw-bold mb-4">Zapytaj o ten sprzęt</h3>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sprzęt</label>
                        <input type="text" class="form-control" value="{{ $equipment->name }}" disabled>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Imię i nazwisko *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telefon</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">E-mail *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Wynajem od</label>
                            <input type="date" name="rental_date_from" class="form-control" value="{{ old('rental_date_from') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Wynajem do</label>
                            <input type="date" name="rental_date_to" class="form-control" value="{{ old('rental_date_to') }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Wiadomość *</label>
                        <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-paper-plane me-2"></i>Wyślij zapytanie
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
