@extends('layouts.public')

@section('title', 'Najczęściej zadawane pytania - ' . ($settings['company_name'] ?? ''))
@section('meta_description', 'Odpowiedzi na najczęściej zadawane pytania dotyczące wynajmu sprzętu.')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
            </ol>
        </nav>
    </div>
</div>

<!-- FAQ Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="fw-bold mb-3">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        Najczęściej zadawane pytania
                    </h1>
                    <p class="lead text-muted">Znajdź odpowiedzi na popularne pytania</p>
                </div>

                @if($faqs->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Wkrótce dodamy odpowiedzi na najczęściej zadawane pytania.
                    </div>
                @else
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $index => $faq)
                        <div class="accordion-item mb-3 border rounded">
                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $faq->id }}">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    <strong>{{ $faq->question }}</strong>
                                </button>
                            </h2>
                            <div id="collapse{{ $faq->id }}"
                                 class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                 aria-labelledby="heading{{ $faq->id }}"
                                 data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                <!-- CTA -->
                <div class="mt-5 p-4 bg-light rounded text-center">
                    <h4>Nie znalazłeś odpowiedzi?</h4>
                    <p class="text-muted mb-3">Skontaktuj się z nami - chętnie pomożemy!</p>
                    <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Wyślij zapytanie
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
