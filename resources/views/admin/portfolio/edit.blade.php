@extends('adminlte::page')
@section('title', 'Edytuj: ' . $portfolio->title)
@section('content_header')<h1><i class="fas fa-edit me-2"></i>Edytuj: {{ $portfolio->title }}</h1>@stop
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                <form action="{{ route('admin.portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('admin.portfolio._form')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dodaj więcej zdjęć</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Zapisz</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-images me-2"></i>Galeria</h5></div>
            <div class="card-body">
                @forelse($portfolio->getMedia('images') as $img)
                <div class="mb-2 border p-2 rounded" id="media-{{ $img->id }}">
                    <img src="{{ $img->getUrl('thumb') }}" class="img-fluid mb-2 rounded">
                    <button type="button" class="btn btn-danger btn-sm w-100 delete-media" data-id="{{ $img->id }}" data-url="{{ route('admin.portfolio.media.delete', [$portfolio, $img->id]) }}">
                        <i class="fas fa-trash"></i> Usuń
                    </button>
                </div>
                @empty
                <p class="text-muted text-center">Brak zdjęć</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@stop
@section('css')<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">@stop
@section('js')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.querySelector('textarea[name="description"]');
    var editor = document.querySelector('.wysiwyg-editor');
    if (textarea && editor) {
        var quill = new Quill(editor, { theme: 'snow', modules: { toolbar: [['bold', 'italic'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['link']] } });
        if (textarea.value) quill.root.innerHTML = textarea.value;
        quill.on('text-change', function() { textarea.value = quill.root.innerHTML; });
        document.querySelector('form').addEventListener('submit', function() { textarea.value = quill.root.innerHTML; });
    }
    document.querySelectorAll('.delete-media').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Usunąć?')) return;
            fetch(this.dataset.url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(r => r.json()).then(data => { if (data.success) document.getElementById('media-' + this.dataset.id).remove(); });
        });
    });
});
</script>
@stop
