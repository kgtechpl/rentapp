@php
    $f = $faq ?? null;
@endphp

<div class="mb-3">
    <label class="form-label fw-bold">Pytanie *</label>
    <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
           value="{{ old('question', $f?->question ?? '') }}" required>
    @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Odpowiedź *</label>
    <textarea name="answer" style="display:none;">{{ old('answer', $f?->answer ?? '') }}</textarea>
    <div class="wysiwyg-editor" style="height: 200px;"></div>
    @error('answer')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Kolejność sortowania</label>
        <input type="number" name="sort_order" class="form-control" min="0"
               value="{{ old('sort_order', $f?->sort_order ?? 0) }}">
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $f?->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Widoczne na stronie</label>
        </div>
    </div>
</div>
