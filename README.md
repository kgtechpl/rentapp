# RENTAPP

**System zarządzania wypożyczalnią sprzętu** – profesjonalna aplikacja Laravel do zarządzania wypożyczalnią narzędzi, maszyn i sprzętu budowlanego.

---

## 📋 O Projekcie

RENTAPP to kompleksowe rozwiązanie dla firm zajmujących się wynajmem sprzętu. System składa się z dwóch części:
- **Panel administracyjny** – zarządzanie sprzętem, kategoriami, zapytaniami, realizacjami, FAQ i ustawieniami
- **Strona publiczna** – katalog sprzętu z wyszukiwarką, galeriami, formularzami kontaktowymi i systemem zapytań

---

## ✨ Funkcjonalności

### 🔍 Strona Publiczna

1. **Live Search** – dynamiczna wyszukiwarka z podpowiedziami (Alpine.js + AJAX)
2. **Katalog sprzętu** – przeglądanie według kategorii ze statusami dostępności (Dostępny/Wynajęty/Ukryty)
3. **Filtry** – sortowanie i filtrowanie sprzętu (cena, kategoria, status)
4. **Galerie zdjęć** – GLightbox z miniaturkami i full-screen preview
5. **Formularze zapytań** – przedwypełnione danymi wybranego sprzętu
6. **Kalendarz dostępności** – wizualizacja dostępności wynajętego sprzętu
7. **Realizacje (Portfolio)** – galeria wykonanych projektów z opisami
8. **FAQ** – sekcja odpowiedzi na często zadawane pytania (accordion)
9. **Strona usług** – edytowalna podstrona prezentująca ofertę usługową
10. **SEO** – meta tagi (Open Graph, Twitter Cards), breadcrumbs, slug URLs
11. **Rate limiting** – ochrona formularzy przed spamem (3 zapytania/60 min)

### ⚙️ Panel Administracyjny

1. **Dashboard** – statystyki, wykresy zapytań (Chart.js), popularny sprzęt
2. **Zarządzanie sprzętem** – CRUD z galeriami zdjęć (Spatie Media Library)
3. **Kategorie** – organizacja sprzętu w kategorie z opisami
4. **Zapytania** – zarządzanie zapytaniami klientów ze statusami (nowe/w trakcie/zamknięte)
5. **Portfolio** – galeria realizacji z kategoryzacją i zdjęciami
6. **FAQ** – zarządzanie pytaniami i odpowiedziami z sortowaniem
7. **Strona usług** – edytor CMS do treści strony usługowej
8. **Ustawienia** – dane firmy, kontakt, WhatsApp, SEO
9. **WYSIWYG Editor** – Quill (opisy, FAQ, portfolio, kategorie, strona usług)
10. **Email autoresponder** – automatyczne potwierdzenie zapytania dla klienta

### 🔔 System Powiadomień Email

- **Admin** – powiadomienie o nowym zapytaniu ze szczegółami
- **Klient** – autoresponder z potwierdzeniem i podsumowaniem zapytania

---

## 🛠️ Stack Technologiczny

### Backend
- **Laravel** 12
- **PHP** 8.2
- **MySQL** (baza danych)
- **Spatie Media Library** ^11 (zarządzanie grafikami)
- **Spatie Sluggable** ^3 (SEO-friendly URLs)

### Frontend
- **AdminLTE** ^3 (Bootstrap 4 dla panelu admin)
- **Bootstrap 5** CDN (strona publiczna)
- **Alpine.js** (live search)
- **Quill** (WYSIWYG editor)
- **Chart.js** 4.4 (wykresy na dashboardzie)
- **GLightbox** (galerie zdjęć)

---

## 🚀 Instalacja i Wdrożenie

### Wymagania

- PHP 8.2+
- Composer
- MySQL 5.7+
- Apache/Nginx z mod_rewrite
- Rozszerzenia PHP: GD/Imagick (przetwarzanie obrazów)

### Instalacja na serwerze

1. **Upload plików** przez FTP/SFTP do katalogu serwera
2. **Instalacja zależności:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Konfiguracja środowiska:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edytuj `.env` i ustaw:
   - `DB_*` – dane dostępu do bazy MySQL
   - `MAIL_*` – konfiguracja SMTP
   - `APP_URL` – adres strony

4. **Migracje i dane startowe:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   ```

5. **Czyszczenie cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

6. **Uprawnienia katalogów:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

### Konfiguracja serwera WWW

**Apache (.htaccess):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx:**
```nginx
root /path/to/rentapp/public;
index index.php;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
}
```

---

## 🔐 Dostęp do Panelu Administracyjnego

**URL:** `https://twoja-domena.pl/admin/login`

**Domyślne dane logowania:**
- Email: `admin@rentapp.pl`
- Hasło: `admin1234`

⚠️ **UWAGA:** Zmień hasło natychmiast po pierwszym logowaniu!

---

## 📂 Struktura Projektu

```
RENTAPP/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Kontrolery panelu admin
│   │   ├── CategoryController.php
│   │   ├── ContactController.php
│   │   ├── EquipmentController.php
│   │   ├── FaqController.php
│   │   ├── PortfolioController.php
│   │   └── ServiceController.php
│   ├── Mail/
│   │   ├── AdminInquiryNotification.php
│   │   └── CustomerConfirmationMail.php
│   └── Models/
│       ├── Category.php
│       ├── ContactInquiry.php
│       ├── Equipment.php
│       ├── Faq.php
│       ├── PortfolioItem.php
│       ├── ServicePage.php
│       ├── Setting.php
│       └── User.php
├── database/
│   ├── migrations/         # Migracje bazy danych
│   └── seeders/           # Dane startowe (admin, kategorie)
├── resources/
│   ├── views/
│   │   ├── admin/         # Widoki panelu admin (AdminLTE)
│   │   ├── categories/    # Katalog kategorii
│   │   ├── emails/        # Szablony email
│   │   ├── equipment/     # Szczegóły sprzętu
│   │   ├── faqs/          # FAQ
│   │   ├── layouts/       # Layout publiczny i admin
│   │   ├── portfolio/     # Realizacje
│   │   └── home.blade.php
│   └── css/               # Style publiczne
├── public/
│   ├── images/            # Logo, grafiki statyczne
│   └── storage/           # Symlink do storage/app/public
├── routes/
│   └── web.php            # Routing publiczny i admin
├── storage/
│   └── app/public/        # Uploaded media (zdjęcia sprzętu)
└── config/
    └── adminlte.php       # Konfiguracja menu admin
```

---

## 🎨 Kluczowe Cechy Techniczne

### Routing SEO
```php
// Publiczne URLs używają slugów
/kategorie/narzedzia-budowlane
/sprzet/wiertarka-udarowa-bosch
/realizacje/budowa-domu-warszawa

// Admin używa ID
/admin/equipment/5/edit
```

### Statusy Sprzętu
- `available` – Dostępny (badge zielony)
- `rented` – Wynajęty (badge żółty, wyświetla datę zwrotu)
- `hidden` – Ukryty (niewidoczny publicznie)

### Media Library
```php
// Konwersje obrazów
'thumb' → 400x300px
'medium' → 800x600px
'large' → 1200x900px (portfolio)
```

### Rate Limiting
```php
// Formularz kontaktowy
Route::post('/kontakt', [ContactController::class, 'store'])
    ->middleware('throttle:3,60'); // 3 zapytania/60 minut
```

---

## 🔧 Workflow Developerski

**Środowisko:**
- **Lokalne:** `D:\PhpstormProjects\RENTAPP` (Laragon + PhpStorm)
- **Produkcja:** `s30.mydevil.net:/usr/home/kgtech/domains/kgtech.pl/public_html/wynajem`
- **Deploy:** PhpStorm SFTP (automatyczny upload przy zapisie)

**Po zmianach na serwerze:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 📧 Konfiguracja Email

W pliku `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.twoja-domena.pl
MAIL_PORT=587
MAIL_USERNAME=wynajem@twoja-domena.pl
MAIL_PASSWORD=haslo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=wynajem@twoja-domena.pl
MAIL_FROM_NAME="RENTAPP Wynajem"
```

---

## 🐛 Rozwiązywanie Problemów

### Błąd "Route not defined"
```bash
php artisan route:clear
php artisan cache:clear
```

### Brak zapisywania zmian w edytorze WYSIWYG
- Upewnij się, że Quill jest załadowany (CDN w sekcji `@section('js')`)
- Sprawdź, czy formularz ma event listener `submit` synchronizujący zawartość

### Błąd 500 po uploadzię zdjęć
```bash
chmod -R 775 storage/app/public
php artisan storage:link
```

### Nie działają zdjęcia
```bash
# Utwórz symlink
php artisan storage:link

# Sprawdź uprawnienia
chmod -R 775 storage
```

---

## 📝 Licencja

Projekt własnościowy. Wszelkie prawa zastrzeżone.

---

## 👤 Autor

**RENTAPP** – System zarządzania wypożyczalnią sprzętu
Zbudowany z Laravel 12 + AdminLTE 3

---

## 📞 Wsparcie

W przypadku problemów:
1. Sprawdź logi: `storage/logs/laravel.log`
2. Wyczyść cache: `php artisan optimize:clear`
3. Sprawdź uprawnienia katalogów `storage/` i `bootstrap/cache/`
