@extends('adminlte::page')

@section('title', 'FAQ')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-question-circle me-2"></i>FAQ</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Dodaj pytanie
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($faqs->isEmpty())
                <p class="text-muted text-center py-4">Brak pytań. Dodaj pierwsze pytanie!</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">Lp.</th>
                            <th>Pytanie</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="150" class="text-right">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <td>{{ $faq->sort_order }}</td>
                            <td>{{ $faq->question }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $faq->is_active ? 'success' : 'secondary' }}">
                                    {{ $faq->is_active ? 'Aktywne' : 'Ukryte' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Usunąć to pytanie?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
@stop
