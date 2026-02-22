@php
    $cat = $category ?? null;
    $catIcon = old('icon', $cat?->icon ?? 'fas fa-tools');
@endphp

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <label class="form-label fw-bold">Nazwa *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $cat?->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Kolejność sortowania</label>
        <input type="number" name="sort_order" class="form-control"
               value="{{ old('sort_order', $cat?->sort_order ?? 0) }}" min="0">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Opis</label>
    <textarea name="description" style="display:none;">{{ old('description', $cat?->description ?? '') }}</textarea>
    <div class="wysiwyg-editor" style="height: 150px;">{!! old('description', $cat?->description ?? '') !!}</div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Ikona FontAwesome</label>
        <div class="input-group">
            <span class="input-group-text" id="icon-preview">
                <i class="{{ $catIcon }}"></i>
            </span>
            <input type="text" name="icon" id="icon-input" class="form-control"
                   value="{{ old('icon', $cat?->icon ?? '') }}"
                   placeholder="np. fas fa-hammer">
        </div>
        <small class="text-muted">Klasa FontAwesome, np. <code>fas fa-hammer</code>, <code>fas fa-seedling</code></small>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Aktywna</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $cat?->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Widoczna na stronie</label>
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-bold">Zdjęcie kategorii</label>
    @if($cat && $cat->getFirstMediaUrl('image', 'thumb'))
        <div class="mb-2">
            <img src="{{ $cat->getFirstMediaUrl('image', 'thumb') }}"
                 class="img-thumbnail" style="height:120px;width:auto;">
            <small class="d-block text-muted mt-1">Aktualne zdjęcie. Wgraj nowe, by je zastąpić.</small>
        </div>
    @endif
    <input type="file" name="image" class="form-control" accept="image/*">
</div>

@push('scripts')
<script>
document.getElementById('icon-input')?.addEventListener('input', function() {
    document.getElementById('icon-preview').innerHTML = '<i class="' + this.value + '"></i>';
});
</script>
@endpush
