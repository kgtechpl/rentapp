@extends('layouts.public')

@section('title', 'Kontakt – ' . ($settings['company_name'] ?? ''))
@section('meta_description', $settings['contact_intro'] ?? 'Skontaktuj się z nami.')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active">Kontakt</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Contact info -->
            <div class="col-md-4">
                <h2 class="fw-bold mb-4">Dane kontaktowe</h2>
                @if(!empty($settings['contact_intro']))
                    <p class="text-muted mb-4">{{ $settings['contact_intro'] }}</p>
                @endif

                <ul class="list-unstyled">
                    @if(!empty($settings['address']))
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-2 fa-fw"></i>
                        <strong>Adres:</strong><br>
                        <span class="ms-4 text-muted">{{ $settings['address'] }}</span>
                    </li>
                    @endif
                    @if(!empty($settings['phone']))
                    <li class="mb-3">
                        <i class="fas fa-phone text-primary me-2 fa-fw"></i>
                        <strong>Telefon:</strong><br>
                        <a href="tel:{{ $settings['phone'] }}" class="ms-4 text-decoration-none">{{ $settings['phone'] }}</a>
                    </li>
                    @endif
                    @if(!empty($settings['email']))
                    <li class="mb-3">
                        <i class="fas fa-envelope text-primary me-2 fa-fw"></i>
                        <strong>E-mail:</strong><br>
                        <a href="mailto:{{ $settings['email'] }}" class="ms-4 text-decoration-none">{{ $settings['email'] }}</a>
                    </li>
                    @endif
                    @if(!empty($settings['whatsapp']))
                    <li class="mb-3">
                        <i class="fab fa-whatsapp text-success me-2 fa-fw"></i>
                        <strong>WhatsApp:</strong><br>
                        <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="ms-4 text-decoration-none">+{{ $settings['whatsapp'] }}</a>
                    </li>
                    @endif
                    @if(!empty($settings['facebook_url']))
                    <li class="mb-3">
                        <i class="fab fa-facebook text-primary me-2 fa-fw"></i>
                        <strong>Facebook:</strong><br>
                        <a href="{{ $settings['facebook_url'] }}" target="_blank" class="ms-4 text-decoration-none">Facebook</a>
                    </li>
                    @endif
                </ul>

                <!-- Quick action buttons -->
                <div class="mt-4 d-grid gap-2">
                    @if(!empty($settings['phone']))
                    <a href="tel:{{ $settings['phone'] }}" class="btn btn-outline-primary">
                        <i class="fas fa-phone me-2"></i>Zadzwoń teraz
                    </a>
                    @endif
                    @if(!empty($settings['whatsapp']))
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn btn-whatsapp">
                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                    </a>
                    @endif
                </div>

                <!-- Google Maps -->
                @if(!empty($settings['google_maps_embed']))
                <div class="mt-4 ratio ratio-4x3 rounded overflow-hidden shadow-sm">
                    {!! $settings['google_maps_embed'] !!}
                </div>
                @endif
            </div>

            <!-- Contact form -->
            <div class="col-md-8">
                <h2 class="fw-bold mb-4">Formularz kontaktowy</h2>

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif

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
                        <label class="form-label fw-bold">Adres e-mail *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sprzęt (opcjonalnie)</label>
                        <select name="equipment_id" class="form-select">
                            <option value="">-- Wybierz sprzęt --</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" {{ old('equipment_id', request('equipment_id')) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} ({{ $item->category->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Wynajem od</label>
                            <input type="date" name="rental_date_from" class="form-control"
                                   value="{{ old('rental_date_from') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Wynajem do</label>
                            <input type="date" name="rental_date_to" class="form-control"
                                   value="{{ old('rental_date_to') }}" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Wiadomość *</label>
                        <textarea name="message" rows="5"
                                  class="form-control @error('message') is-invalid @enderror"
                                  placeholder="Opisz swoje zapytanie..." required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Wyślij zapytanie
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
