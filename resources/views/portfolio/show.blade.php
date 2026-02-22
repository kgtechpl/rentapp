@extends('layouts.public')
@section('title', $portfolio->title . ' - Realizacje')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portfolio.index') }}">Realizacje</a></li>
            <li class="breadcrumb-item active">{{ $portfolio->title }}</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-3">{{ $portfolio->title }}</h1>
        @if($portfolio->category)<span class="badge bg-primary mb-3">{{ $portfolio->category }}</span>@endif
        @if($portfolio->completion_date)<p class="text-muted"><i class="fas fa-calendar me-1"></i>{{ $portfolio->completion_date->format('F Y') }}</p>@endif
        @if($portfolio->description)<div class="mb-4">{!! $portfolio->description !!}</div>@endif
        <div class="row g-3">
            @foreach($portfolio->getMedia('images') as $img)
            <div class="col-md-4">
                <a href="{{ $img->getUrl() }}" class="glightbox" data-gallery="portfolio">
                    <img src="{{ $img->getUrl('thumb') }}" class="img-fluid rounded shadow-sm" alt="{{ $portfolio->title }}">
                </a>
            </div>
            @endforeach
        </div>
        <div class="mt-4"><a href="{{ route('portfolio.index') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Powrót do realizacji</a></div>
    </div>
</section>
@endsection
