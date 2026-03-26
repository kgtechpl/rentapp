@php
    $eq = $equipment ?? null;
    $currentStatus = old('status', $eq?->status ?? 'available');
@endphp

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Kategorie *</label>
        <select name="categories[]" id="categories-select" class="form-control select2 @error('categories') is-invalid @enderror" multiple required data-placeholder="Wybierz kategorie...">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ in_array($cat->id, old('categories', $eq?->categories->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('categories')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Marka</label>
        <input type="text" name="brand" class="form-control"
               value="{{ old('brand', $eq?->brand ?? '') }}" placeholder="np. Bosch, Husqvarna">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Nazwa sprzętu *</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $eq?->name ?? '') }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Opis</label>
    <textarea name="description" style="display:none;">{{ old('description', $eq?->description ?? '') }}</textarea>
    <div class="wysiwyg-editor" style="height: 200px;">{!! old('description', $eq?->description ?? '') !!}</div>
</div>

<div class="mb-3">
    <label class="form-label">Stan techniczny / notatki</label>
    <textarea name="condition_notes" rows="2" class="form-control">{{ old('condition_notes', $eq?->condition_notes ?? '') }}</textarea>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0"><i class="fas fa-tags me-2"></i>Cennik (zł/dzień)</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">1 dzień</label>
                <input type="number" name="price_per_day" class="form-control" step="0.01" min="0"
                       value="{{ old('price_per_day', $eq?->price_per_day ?? '') }}" placeholder="np. 100">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">3-6 dni</label>
                <input type="number" name="price_3_days" class="form-control" step="0.01" min="0"
                       value="{{ old('price_3_days', $eq?->price_3_days ?? '') }}" placeholder="np. 90">
                <small class="text-muted">Opcjonalne</small>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">7-13 dni</label>
                <input type="number" name="price_7_days" class="form-control" step="0.01" min="0"
                       value="{{ old('price_7_days', $eq?->price_7_days ?? '') }}" placeholder="np. 80">
                <small class="text-muted">Opcjonalne</small>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">14+ dni</label>
                <input type="number" name="price_14_days" class="form-control" step="0.01" min="0"
                       value="{{ old('price_14_days', $eq?->price_14_days ?? '') }}" placeholder="np. 70">
                <small class="text-muted">Opcjonalne</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label fw-bold">Kaucja (zł)</label>
        <input type="number" name="deposit" class="form-control" step="0.01" min="0"
               value="{{ old('deposit', $eq?->deposit ?? '') }}" placeholder="Zostaw puste">
    </div>
    <div class="col-md-4 d-flex align-items-end pb-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_price_negotiable" value="1"
                   {{ old('is_price_negotiable', $eq?->is_price_negotiable ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Cena do negocjacji</label>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-end pb-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured', $eq?->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Polecany (strona główna)</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="service_available" value="1"
               {{ old('service_available', $eq?->service_available ?? false) ? 'checked' : '' }}>
        <label class="form-check-label fw-bold">
            <i class="fas fa-wrench text-primary"></i> Możliwa usługa tym narzędziem
            <small class="text-muted d-block">Zaznacz, jeśli oferujesz usługi z wykorzystaniem tego sprzętu</small>
        </label>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label fw-bold">Status</label>
        <select name="status" id="status-select" class="form-select @error('status') is-invalid @enderror" required>
            <option value="available" {{ $currentStatus === 'available' ? 'selected' : '' }}>Dostępny</option>
            <option value="rented" {{ $currentStatus === 'rented' ? 'selected' : '' }}>Wynajęty</option>
            <option value="hidden" {{ $currentStatus === 'hidden' ? 'selected' : '' }}>Ukryty</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4" id="rented-until-field"
         style="{{ $currentStatus !== 'rented' ? 'display:none' : '' }}">
        <label class="form-label fw-bold">Wynajęty do</label>
        <input type="date" name="rented_until" class="form-control @error('rented_until') is-invalid @enderror"
               value="{{ old('rented_until', $eq?->rented_until?->format('Y-m-d') ?? '') }}">
        @error('rented_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Kolejność sortowania</label>
        <input type="number" name="sort_order" class="form-control" min="0"
               value="{{ old('sort_order', $eq?->sort_order ?? 0) }}">
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    // Initialize Select2 for categories
    $('#categories-select').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Wybierz kategorie...',
        allowClear: false
    });

    // Status field toggle
    document.getElementById('status-select')?.addEventListener('change', function() {
        document.getElementById('rented-until-field').style.display = this.value === 'rented' ? '' : 'none';
    });
});
</script>
@endpush
