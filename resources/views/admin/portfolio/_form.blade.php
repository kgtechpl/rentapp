@php $item = $portfolio ?? null; @endphp
<div class="mb-3">
    <label class="form-label fw-bold">Tytuł *</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $item?->title ?? '') }}" required>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label fw-bold">Opis</label>
    <textarea name="description" style="display:none;">{{ old('description', $item?->description ?? '') }}</textarea>
    <div class="wysiwyg-editor" style="height: 200px;"></div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">Kategoria</label>
        <input type="text" name="category" class="form-control" value="{{ old('category', $item?->category ?? '') }}" placeholder="np. Ogród">
    </div>
    <div class="col-md-4">
        <label class="form-label">Data realizacji</label>
        <input type="date" name="completion_date" class="form-control" value="{{ old('completion_date', $item?->completion_date?->format('Y-m-d') ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Kolejność</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
    </div>
</div>
<div class="mb-3">
    <div class="form-check d-inline-block me-3">
        <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item?->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label">Wyróżnione</label>
    </div>
    <div class="form-check d-inline-block">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label">Aktywne</label>
    </div>
</div>
