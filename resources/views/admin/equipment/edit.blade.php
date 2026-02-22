@extends('adminlte::page')

@section('title', 'Edytuj: ' . $equipment->name)
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-edit mr-2"></i>Edytuj: {{ $equipment->name }}</h1>
        <div>
            <a href="{{ route('equipment.show', $equipment) }}" target="_blank" class="btn btn-outline-info btn-sm mr-2">
                <i class="fas fa-external-link-alt mr-1"></i>Podgląd
            </a>
            <a href="{{ route('admin.equipment.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i>Powrót
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <!-- Main form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <i class="fas fa-check mr-2"></i>{{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('admin.equipment.update', $equipment) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('admin.equipment._form')

                    <div class="form-group">
                        <label class="font-weight-bold">Dodaj więcej zdjęć</label>
                        <input type="file" name="images[]" class="form-control-file" accept="image/*" multiple>
                        <small class="text-muted">Możesz wybrać wiele plików. Max 4MB każdy.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-2"></i>Zapisz zmiany
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Image gallery -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-images mr-2"></i>Galeria zdjęć</h5>
            </div>
            <div class="card-body" id="gallery-container">
                @php $images = $equipment->getMedia('images'); @endphp
                @forelse($images as $img)
                <div class="d-flex align-items-center mb-2 p-2 border rounded" id="media-{{ $img->id }}">
                    <img src="{{ $img->getUrl('thumb') }}"
                         style="width:60px;height:45px;object-fit:cover;border-radius:4px;" class="mr-2">
                    <div class="flex-grow-1 small">
                        <div class="text-truncate" style="max-width:120px;">{{ $img->file_name }}</div>
                        <small class="text-muted">{{ round($img->size / 1024) }} KB</small>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm ml-auto delete-media"
                            data-id="{{ $img->id }}"
                            data-url="{{ route('admin.equipment.media.delete', [$equipment, $img->id]) }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                @empty
                <p class="text-muted text-center py-3">Brak zdjęć</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script>
document.querySelectorAll('.delete-media').forEach(function(btn) {
    btn.addEventListener('click', function() {
        if (!confirm('Usunąć to zdjęcie?')) return;
        var id = this.dataset.id;
        var url = this.dataset.url;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var el = document.getElementById('media-' + id);
                if (el) el.remove();
            }
        })
        .catch(function() { alert('Błąd podczas usuwania zdjęcia.'); });
    });
});
</script>
@endpush
