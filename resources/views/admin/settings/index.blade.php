@extends('adminlte::page')

@section('title', 'Ustawienia')
@section('content_header')
    <h1><i class="fas fa-cog mr-2"></i>Ustawienia strony</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <i class="fas fa-check mr-2"></i>{{ session('success') }}
</div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-building mr-2"></i>Dane firmy</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Nazwa firmy *</label>
                        <input type="text" name="settings[company_name]" class="form-control"
                               value="{{ $settings['company_name'] ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Adres</label>
                        <input type="text" name="settings[address]" class="form-control"
                               value="{{ $settings['address'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Telefon</label>
                        <input type="text" name="settings[phone]" class="form-control"
                               value="{{ $settings['phone'] ?? '' }}" placeholder="+48 123 456 789">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">E-mail (odbiera powiadomienia)</label>
                        <input type="email" name="settings[email]" class="form-control"
                               value="{{ $settings['email'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">WhatsApp (numer bez +, np. 48123456789)</label>
                        <input type="text" name="settings[whatsapp]" class="form-control"
                               value="{{ $settings['whatsapp'] ?? '' }}" placeholder="48123456789">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">URL strony Facebook</label>
                        <input type="url" name="settings[facebook_url]" class="form-control"
                               value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/...">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-file-alt mr-2"></i>Treści na stronie</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Tytuł hero (strona główna)</label>
                        <input type="text" name="settings[hero_title]" class="form-control"
                               value="{{ $settings['hero_title'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Podtytuł hero</label>
                        <textarea name="settings[hero_subtitle]" rows="3" class="form-control">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Intro kontaktowy (sekcja CTA)</label>
                        <textarea name="settings[contact_intro]" rows="3" class="form-control">{{ $settings['contact_intro'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Google Maps embed (iframe HTML)</label>
                        <textarea name="settings[google_maps_embed]" rows="4"
                                  class="form-control font-monospace"
                                  style="font-size:11px;"
                                  placeholder='&lt;iframe src="https://maps.google.com/..." ...&gt;&lt;/iframe&gt;'>{{ $settings['google_maps_embed'] ?? '' }}</textarea>
                        <small class="text-muted">Wklej pełny kod iframe z Google Maps</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 mb-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save mr-2"></i>Zapisz wszystkie ustawienia
        </button>
    </div>
</form>
@stop
