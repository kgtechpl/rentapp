<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', $settings['hero_subtitle'] ?? '')">
    <meta property="og:title" content="@yield('title', $settings['company_name'] ?? 'Wynajem sprzętu')">
    <meta property="og:description" content="@yield('meta_description', $settings['hero_subtitle'] ?? '')">
    <meta property="og:type" content="website">
    <title>@yield('title', $settings['company_name'] ?? 'Wynajem sprzętu')</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        :root {
            --primary: #1a5276;
            --accent: #f39c12;
        }
        body { font-family: 'Segoe UI', sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, #2980b9 100%);
            padding: 80px 0;
            color: white;
        }
        .hero-section h1 { font-size: 2.5rem; font-weight: 700; }
        .category-card { transition: transform .2s, box-shadow .2s; cursor: pointer; }
        .category-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .category-icon { font-size: 2.5rem; color: var(--primary); }
        .equipment-card { height: 100%; }
        .equipment-card .card-img-top { height: 200px; object-fit: cover; }
        .contact-strip { background: var(--primary); color: white; padding: 40px 0; }
        .btn-whatsapp { background: #25d366; color: white; }
        .btn-whatsapp:hover { background: #1da851; color: white; }
        footer { background: #1a252f; color: #aaa; padding: 30px 0; }
        footer a { color: #aaa; text-decoration: none; }
        footer a:hover { color: white; }
        .breadcrumb-section { background: #f8f9fa; padding: 12px 0; border-bottom: 1px solid #dee2e6; }
        .filter-bar .btn { border-radius: 20px; }
        .no-image-placeholder { height: 200px; background: #e9ecef; display: flex; align-items: center; justify-content: center; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--primary);">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-tools me-2"></i>{{ $settings['company_name'] ?? 'Wynajem Sprzętu' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Sprzęt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">Kontakt</a>
                </li>
            </ul>
            @if(!empty($settings['phone']))
            <a href="tel:{{ $settings['phone'] }}" class="btn btn-warning ms-3 fw-bold">
                <i class="fas fa-phone me-1"></i>{{ $settings['phone'] }}
            </a>
            @endif
        </div>
    </div>
</nav>

<!-- Flash messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
    <div class="container">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@yield('content')

<!-- Contact Strip -->
<div class="contact-strip">
    <div class="container text-center">
        <h3 class="mb-3">Masz pytania? Zadzwoń lub napisz!</h3>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @if(!empty($settings['phone']))
            <a href="tel:{{ $settings['phone'] }}" class="btn btn-warning btn-lg">
                <i class="fas fa-phone me-2"></i>{{ $settings['phone'] }}
            </a>
            @endif
            @if(!empty($settings['whatsapp']))
            <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn btn-whatsapp btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
            @endif
            @if(!empty($settings['email']))
            <a href="mailto:{{ $settings['email'] }}" class="btn btn-light btn-lg">
                <i class="fas fa-envelope me-2"></i>{{ $settings['email'] }}
            </a>
            @endif
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">{{ $settings['company_name'] ?? '' }}</h5>
                @if(!empty($settings['address']))<p><i class="fas fa-map-marker-alt me-2"></i>{{ $settings['address'] }}</p>@endif
                @if(!empty($settings['phone']))<p><i class="fas fa-phone me-2"></i><a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></p>@endif
                @if(!empty($settings['email']))<p><i class="fas fa-envelope me-2"></i><a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></p>@endif
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">Nawigacja</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Strona główna</a></li>
                    <li><a href="{{ route('categories.index') }}">Sprzęt do wynajęcia</a></li>
                    <li><a href="{{ route('contact.index') }}">Kontakt</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">Śledź nas</h5>
                @if(!empty($settings['facebook_url']))
                <a href="{{ $settings['facebook_url'] }}" target="_blank" class="btn btn-outline-light me-2 mb-2">
                    <i class="fab fa-facebook me-1"></i>Facebook
                </a>
                @endif
                @if(!empty($settings['whatsapp']))
                <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn btn-outline-light mb-2">
                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                </a>
                @endif
            </div>
        </div>
        <hr style="border-color: #333;">
        <p class="text-center mb-0 small">&copy; {{ date('Y') }} {{ $settings['company_name'] ?? '' }}. Wszelkie prawa zastrzeżone.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({ selector: '.glightbox' });
</script>
@stack('scripts')
</body>
</html>
