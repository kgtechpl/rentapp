@extends('layouts.public')

@section('title', $equipment->name . ' – ' . ($settings['company_name'] ?? ''))
@section('meta_description', Str::limit(strip_tags($equipment->description ?? $equipment->name), 160))
@section('og_type', 'product')
@section('og_image', $equipment->getFirstMediaUrl('images') ?: asset('images/logo.png'))
@section('meta_keywords', $equipment->categories->pluck('name')->join(', ') . ', ' . ($equipment->brand ?? 'wynajem') . ', wynajem sprzętu, ' . $equipment->name)

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Sprzęt</a></li>
                @if($equipment->categories->isNotEmpty())
                <li class="breadcrumb-item"><a href="{{ route('categories.show', $equipment->categories->first()) }}">{{ $equipment->categories->first()->name }}</a></li>
                @endif
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
                @if($equipment->categories->isNotEmpty())
                <div class="mb-2">
                    <i class="fas fa-tag me-1 text-muted"></i>
                    @foreach($equipment->categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="badge bg-primary text-decoration-none me-1">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                @endif
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

                <!-- Pricing -->
                @php $pricingTiers = $equipment->getPricingTiers(); @endphp
                @if(count($pricingTiers) > 1)
                <div class="bg-light rounded p-3 mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-tag me-2"></i>Cennik</h5>
                    <table class="table table-sm table-borderless mb-0">
                        @foreach($pricingTiers as $tier)
                        <tr>
                            <td class="text-muted">{{ $tier['days'] }}</td>
                            <td class="text-end fw-bold text-primary">{{ $tier['formatted'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @if($equipment->deposit)
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-shield-alt me-1"></i>Kaucja</span>
                        <strong class="text-primary">{{ $equipment->deposit_display }}</strong>
                    </div>
                    @endif
                </div>

                <!-- Price Calculator -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="fas fa-calculator me-2"></i>Kalkulator ceny</h6>
                        <div class="row g-2">
                            <div class="col-5">
                                <label class="form-label small">Ilość dni</label>
                                <input type="number" id="calc-days" class="form-control" min="1" value="1" placeholder="np. 7">
                            </div>
                            <div class="col-7 d-flex align-items-end">
                                <div class="w-100">
                                    <div id="calc-result" class="alert alert-primary mb-0 py-2">
                                        <strong>Koszt:</strong> <span id="calc-total" class="fw-bold">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-primary bg-opacity-10 rounded p-3 mb-4">
                    <h4 class="text-primary fw-bold mb-0">{{ $equipment->price_display }}</h4>
                    @if($equipment->deposit)
                    <p class="text-muted mb-0 mt-2">
                        <i class="fas fa-shield-alt me-1"></i>Kaucja: <strong class="text-primary">{{ $equipment->deposit_display }}</strong>
                    </p>
                    @endif
                </div>
                @endif

                <!-- Service Available -->
                @if($equipment->service_available)
                <div class="alert alert-warning mb-4">
                    <h6 class="fw-bold">
                        <i class="fas fa-wrench me-2"></i>Możliwa usługa tym sprzętem
                    </h6>
                    <p class="mb-2">Nie chcesz wynajmować? Możemy wykonać pracę za Ciebie!</p>
                    <a href="{{ route('services.index') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-arrow-right me-1"></i>Zobacz usługi
                    </a>
                </div>
                @endif

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calcDaysInput = document.getElementById('calc-days');
    const calcTotal = document.getElementById('calc-total');

    if (!calcDaysInput) return;

    // Pricing data from backend
    const pricing = {
        price_1: {{ $equipment->price_per_day ?? 0 }},
        price_3: {{ $equipment->price_3_days ?? 0 }},
        price_7: {{ $equipment->price_7_days ?? 0 }},
        price_14: {{ $equipment->price_14_days ?? 0 }}
    };

    function calculatePrice(days) {
        let pricePerDay = pricing.price_1;

        if (days >= 14 && pricing.price_14 > 0) {
            pricePerDay = pricing.price_14;
        } else if (days >= 7 && pricing.price_7 > 0) {
            pricePerDay = pricing.price_7;
        } else if (days >= 3 && pricing.price_3 > 0) {
            pricePerDay = pricing.price_3;
        }

        return pricePerDay * days;
    }

    function updateCalculator() {
        const days = parseInt(calcDaysInput.value) || 1;
        const total = calculatePrice(days);

        if (total > 0) {
            calcTotal.textContent = total.toLocaleString('pl-PL', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' zł';
        } else {
            calcTotal.textContent = 'Cena do uzgodnienia';
        }
    }

    calcDaysInput.addEventListener('input', updateCalculator);
    updateCalculator(); // Initial calculation
});
</script>
@endpush

@endsection
