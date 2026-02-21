# Kingsbridge Motors (kb-v1.5)

Kingsbridge Motors is a Laravel 8 marketplace for vehicle sales, spare parts, car hire, and events.

## Tech Stack
- PHP 8.x / Laravel 8
- MySQL (default), with optional Sail services for PostgreSQL, MariaDB, and Redis
- Blade templates + jQuery + Bootstrap 4
- Laravel Mix for frontend asset builds

## Quick Start (Local)
1. Install dependencies:
```bash
composer install
npm install
```
2. Create environment file:
```bash
cp .env.example .env
php artisan key:generate
```
3. Configure database in `.env` (`DB_*` values).
4. Run migrations and seeders:
```bash
php artisan migrate --seed
```
5. Build frontend assets:
```bash
npm run dev
```
6. Start the app:
```bash
php artisan serve
```

The app will be available at `http://127.0.0.1:8000` by default.

## Quick Start (Laravel Sail)
1. Install dependencies and create environment:
```bash
composer install
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
```
2. Run migrations and seeders:
```bash
./vendor/bin/sail artisan migrate --seed
```
3. Build frontend assets:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

## Common Commands
```bash
php artisan route:list
php artisan migrate
php artisan db:seed
php artisan test
npm run watch
npm run prod
```

## Core Areas
- Public pages and search: `app/Http/Controllers/PagesController.php`
- User listing flows: `app/Http/Controllers/User/ListingController.php`
- Admin dashboards/resources: `app/Http/Controllers/Admin/*`
- Main web routes: `routes/web.php`
- Shared layout: `resources/views/layouts/kingsbridge.blade.php`

## Environment Variables
Minimum required variables for local use:
- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

Optional integrations in this project:
- Google social login: `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`
- M-Pesa: `MPESA_*`, `SAFARICOM_PASSKEY`
- Twilio: `TWILIO_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_PHONE_NUMBER`

## Troubleshooting
- `Target class ... does not exist` on route listing:
  - Run `composer dump-autoload` and re-check `routes/web.php` imports.
- Missing frontend styles/scripts:
  - Run `npm run dev` and verify `public/mix-manifest.json` exists.
- Seeder errors:
  - Confirm DB credentials and run `php artisan migrate:fresh --seed` in non-production environments.

## Current Improvement Focus
This repository contains legacy Blade pages with mixed inline scripts and duplicated frontend includes. Stabilization work should prioritize:
1. Route/controller consistency.
2. Shared asset management via the main layout.
3. Query/load optimizations on listing-heavy pages.
4. Feature tests for critical public/user/admin paths.
