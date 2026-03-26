@extends('adminlte::page')

@section('title', 'Dodaj sprzęt')

{{-- Enable Select2 plugin --}}
@section('plugins.Select2', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-plus me-2"></i>Dodaj sprzęt</h1>
        <a href="{{ route('admin.equipment.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Powrót
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.equipment._form')

            <div class="mb-4">
                <label class="form-label fw-bold">Zdjęcia (można dodać więcej po zapisaniu)</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">Możesz wybrać wiele plików. Max 4MB każdy.</small>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Zapisz i przejdź do edycji
            </button>
        </form>
    </div>
</div>
@stop

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editors = [];

            document.querySelectorAll('.wysiwyg-editor').forEach(function(element) {
                var editor = new Quill(element, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });

                var textarea = element.previousElementSibling;
                editor.on('text-change', function() {
                    textarea.value = editor.root.innerHTML;
                });

                editors.push({ editor: editor, textarea: textarea });
            });

            // Sync before submit
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    editors.forEach(function(item) {
                        item.textarea.value = item.editor.root.innerHTML;
                    });
                });
            });
        });
    </script>
@stop
