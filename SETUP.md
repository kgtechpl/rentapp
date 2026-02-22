# RENTAPP – Instrukcja uruchomienia na serwerze

## Wymagania

Pakiety muszą być zainstalowane. Sprawdź `composer.json`:
- `jeroennoten/laravel-adminlte ^3`
- `spatie/laravel-medialibrary ^11`
- `spatie/laravel-sluggable ^3`

## Kroki na serwerze (SSH)

```bash
# 1. Wejdź do katalogu projektu
cd /usr/home/kgtech/domains/wynajem.kgtech.pl/public_html

# 2. Zainstaluj / zaktualizuj pakiety
composer install --no-dev --optimize-autoloader

# 3. Opublikuj assets AdminLTE (jeśli nie zrobione)
php artisan adminlte:install

# 4. Uruchom migracje
php artisan migrate

# 5. Uruchom seedery (admin user + ustawienia + kategorie)
php artisan db:seed

# 6. Wyczyść cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 7. Wygeneruj symlink dla storage (jeśli nie istnieje)
php artisan storage:link

# 8. (Opcjonalnie) Optymalizacja produkcyjna
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Dane logowania do panelu

- **URL**: `/admin/login`
- **E-mail**: `admin@rentapp.pl`
- **Hasło**: `admin1234`

> **Ważne**: Zmień hasło po pierwszym logowaniu!

## Konfiguracja .env

Upewnij się, że `.env` ma poprawne dane:

```
APP_URL=https://wynajem.kgtech.pl
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@kgtech.pl
MAIL_FROM_NAME="RENTAPP"

FILESYSTEM_DISK=public
```

## Struktura URL

| Strona | URL |
|--------|-----|
| Strona główna | `/` |
| Lista kategorii | `/kategorie` |
| Kategoria | `/kategorie/{slug}` |
| Sprzęt | `/sprzet/{slug}` |
| Kontakt | `/kontakt` |
| Panel admina | `/admin` |
| Logowanie | `/admin/login` |
