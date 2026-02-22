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
@endsection
