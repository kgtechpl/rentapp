<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #1a5276;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .footer {
            background: #343a40;
            color: #adb5bd;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            border-radius: 0 0 5px 5px;
        }
        .highlight {
            background: #fff3cd;
            padding: 15px;
            border-left: 4px solid #f39c12;
            margin: 20px 0;
        }
        .info-box {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">{{ config('app.name', 'Wynajem Sprzętu') }}</h1>
    </div>

    <div class="content">
        <h2>Dziękujemy za kontakt!</h2>

        <p>Witaj <strong>{{ $inquiry->name }}</strong>,</p>

        <p>Otrzymaliśmy Twoje zapytanie i potwierdzamy jego przyjęcie. Nasz zespół przeanalizuje Twoją prośbę i skontaktuje się z Tobą <strong>w ciągu najbliższych 24 godzin</strong>.</p>

        <div class="highlight">
            <strong>📋 Podsumowanie Twojego zapytania:</strong>
        </div>

        <div class="info-box">
            @if($inquiry->equipment)
                <p><strong>Sprzęt:</strong> {{ $inquiry->equipment->name }}</p>
            @endif

            @if($inquiry->rental_date_from || $inquiry->rental_date_to)
                <p><strong>Termin wynajmu:</strong>
                    @if($inquiry->rental_date_from)
                        od {{ \Carbon\Carbon::parse($inquiry->rental_date_from)->format('d.m.Y') }}
                    @endif
                    @if($inquiry->rental_date_to)
                        do {{ \Carbon\Carbon::parse($inquiry->rental_date_to)->format('d.m.Y') }}
                    @endif
                </p>
            @endif

            <p><strong>Twoja wiadomość:</strong><br>{{ $inquiry->message }}</p>
        </div>

        <p style="margin-top: 30px;">
            <strong>Masz dodatkowe pytania?</strong><br>
            Możesz skontaktować się z nami bezpośrednio:
        </p>

        <ul>
            @if(!empty($settings['phone']))
                <li>📞 Telefon: <a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></li>
            @endif
            @if(!empty($settings['email']))
                <li>✉️ Email: <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></li>
            @endif
        </ul>

        <p style="margin-top: 30px; font-style: italic; color: #666;">
            Pozdrawiamy serdecznie!<br>
            Zespół {{ config('app.name', 'Wynajem Sprzętu') }}
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">
            Ten email został wysłany automatycznie. Prosimy nie odpowiadać na tę wiadomość.
        </p>
    </div>
</body>
</html>
