@extends('layouts.public')

@section('title', 'Sprzęt do wynajęcia – ' . ($settings['company_name'] ?? ''))
@section('meta_description', 'Przeglądaj wszystkie kategorie sprzętu dostępnego do wynajęcia.')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                <li class="breadcrumb-item active">Sprzęt</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Sprzęt do wynajęcia</h1>

        <!-- Live Search -->
        <div class="mb-4" x-data="searchWidget()">
            <div class="position-relative">
                <input type="text"
                       class="form-control form-control-lg"
                       placeholder="Szukaj sprzętu..."
                       x-model="query"
                       @input.debounce.300ms="search()">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
            </div>

            <!-- Search Results -->
            <div x-show="results.length > 0" class="card mt-2 shadow-sm" style="display: none;">
                <div class="list-group list-group-flush">
                    <template x-for="item in results" :key="item.id">
                        <a :href="item.url" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <img :src="item.image || '/placeholder.png'"
                                     class="me-3 rounded"
                                     style="width:60px;height:45px;object-fit:cover;"
                                     :alt="item.name"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'45\'%3E%3Crect width=\'60\' height=\'45\' fill=\'%23e9ecef\'/%3E%3C/svg%3E'">
                                <div class="flex-grow-1">
                                    <div class="fw-bold" x-text="item.name"></div>
                                    <small class="text-muted">
                                        <span x-text="item.category"></span>
                                        <span x-show="item.brand"> • <span x-text="item.brand"></span></span>
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary" x-text="item.price"></div>
                                    <small class="badge bg-secondary" x-text="item.status"></small>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </div>
        </div>

        @if($categories->isEmpty())
            <div class="alert alert-info">Brak kategorii. Sprawdź wkrótce!</div>
        @else
        <div class="row g-4">
            @foreach($categories as $cat)
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('categories.show', $cat) }}" class="text-decoration-none">
                    <div class="card category-card h-100 shadow-sm">
                        @if($cat->getFirstMediaUrl('image', 'thumb'))
                            <img src="{{ $cat->getFirstMediaUrl('image', 'thumb') }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;"
                                 alt="{{ $cat->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                                <i class="{{ $cat->icon ?? 'fas fa-tools' }} fa-3x text-primary"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-dark">
                                @if($cat->icon)<i class="{{ $cat->icon }} me-2 text-primary"></i>@endif
                                {{ $cat->name }}
                            </h5>
                            @if($cat->description)
                            <p class="card-text text-muted small">{{ Str::limit(strip_tags($cat->description), 100) }}</p>
                            @endif
                            <span class="badge bg-primary">{{ $cat->active_equipment_count }} pozycji</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function searchWidget() {
        return {
            query: '',
            results: [],
            search() {
                if (this.query.length < 2) {
                    this.results = [];
                    return;
                }

                fetch('/api/search?q=' + encodeURIComponent(this.query))
                    .then(response => response.json())
                    .then(data => {
                        this.results = data;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        this.results = [];
                    });
            }
        };
    }
</script>
@endpush
