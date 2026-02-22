@extends('adminlte::page')
@section('title', 'Dodaj realizację')
@section('content_header')
    <h1><i class="fas fa-plus me-2"></i>Dodaj realizację</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.portfolio._form')
                <div class="mb-3">
                    <label class="form-label fw-bold">Zdjęcia</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Możesz wybrać wiele plików</small>
                </div>
                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Zapisz</button>
            </form>
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
});
</script>
@stop
