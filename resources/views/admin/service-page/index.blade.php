@extends('adminlte::page')

@section('title', 'Strona usług')

@section('content_header')
    <h1>Strona usług</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.service-page.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Tytuł strony</label>
                    <input type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           id="title"
                           name="title"
                           value="{{ old('title', $servicePage->title) }}"
                           required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Treść</label>
                    <textarea id="content" name="content" style="display:none;">{{ old('content', $servicePage->content) }}</textarea>
                    <div id="content-editor" class="wysiwyg-editor @error('content') border-danger @enderror" style="height: 300px;"></div>
                    @error('content')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $servicePage->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Strona aktywna</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Zapisz
                </button>
                <a href="{{ route('services.index') }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-eye"></i> Podgląd
                </a>
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
            // Znajdź textarea i edytor
            var contentTextarea = document.getElementById('content');
            var editorElement = document.getElementById('content-editor');

            if (contentTextarea && editorElement) {
                // Inicjalizuj Quill
                var quill = new Quill(editorElement, {
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

                // Załaduj istniejącą zawartość
                if (contentTextarea.value) {
                    quill.root.innerHTML = contentTextarea.value;
                }

                // Synchronizuj podczas pisania
                quill.on('text-change', function() {
                    contentTextarea.value = quill.root.innerHTML;
                });

                // WAŻNE: Synchronizuj przed submit
                var form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        contentTextarea.value = quill.root.innerHTML;
                        console.log('Zapisuję:', contentTextarea.value); // Debug
                    });
                }
            }
        });
    </script>
@stop
