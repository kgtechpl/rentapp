@extends('adminlte::page')

@section('title', 'Dodaj pytanie FAQ')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-plus me-2"></i>Dodaj pytanie FAQ</h1>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Powrót
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                @include('admin.faqs._form')
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Zapisz
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
            var answerTextarea = document.querySelector('textarea[name="answer"]');
            var editorElement = document.querySelector('.wysiwyg-editor');

            if (answerTextarea && editorElement) {
                var quill = new Quill(editorElement, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                if (answerTextarea.value) {
                    quill.root.innerHTML = answerTextarea.value;
                }

                quill.on('text-change', function() {
                    answerTextarea.value = quill.root.innerHTML;
                });

                document.querySelector('form').addEventListener('submit', function() {
                    answerTextarea.value = quill.root.innerHTML;
                });
            }
        });
    </script>
@stop
