<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a5276; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 8px 8px; }
        .field { margin-bottom: 12px; }
        .label { font-weight: bold; color: #555; }
        .value { color: #333; }
        .btn { display: inline-block; background: #1a5276; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2 style="margin:0;">Nowe zapytanie o sprzęt</h2>
        <p style="margin:4px 0 0;">{{ $inquiry->created_at->format('d.m.Y H:i') }}</p>
    </div>
    <div class="content">
        <div class="field">
            <div class="label">Imię i nazwisko:</div>
            <div class="value">{{ $inquiry->name }}</div>
        </div>
        <div class="field">
            <div class="label">E-mail:</div>
            <div class="value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
        </div>
        @if($inquiry->phone)
        <div class="field">
            <div class="label">Telefon:</div>
            <div class="value"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></div>
        </div>
        @endif
        @if($inquiry->equipment)
        <div class="field">
            <div class="label">Pytanie o sprzęt:</div>
            <div class="value">{{ $inquiry->equipment->name }}</div>
        </div>
        @endif
        @if($inquiry->rental_date_from)
        <div class="field">
            <div class="label">Wynajem od:</div>
            <div class="value">{{ $inquiry->rental_date_from->format('d.m.Y') }}</div>
        </div>
        @endif
        @if($inquiry->rental_date_to)
        <div class="field">
            <div class="label">Wynajem do:</div>
            <div class="value">{{ $inquiry->rental_date_to->format('d.m.Y') }}</div>
        </div>
        @endif
        <div class="field">
            <div class="label">Wiadomość:</div>
            <div class="value" style="white-space: pre-wrap; background: white; padding: 10px; border-radius: 4px; border-left: 4px solid #1a5276;">{{ $inquiry->message }}</div>
        </div>

        <p style="margin-top: 20px;">
            <a href="{{ url('/admin/inquiries/' . $inquiry->id) }}" class="btn">Otwórz zapytanie w panelu →</a>
        </p>
    </div>
</div>
</body>
</html>
