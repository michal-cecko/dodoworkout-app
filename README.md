# DodoWorkout

Public website with blog, event sign-ups, custom forms, payment-enabled orders and a Filament CMS for DodoWorkout (Slovak fitness brand).

## What it does

- **Public site** — multilingual (SK + EN), localized routes, marketing pages
- **Events** — categorised events with public registration flow and capacity limits
- **Blog** — posts with rich content (TipTap editor), categories, translations
- **Forms** — custom form builder; field types, submissions store, email notifications
- **Orders & payments** — order line items, multiple payment types
- **Admin panel** — Filament v5, content editing in both languages side-by-side

## Stack

| Layer | Tech |
|---|---|
| Backend | **Laravel 12** on PHP 8.4 |
| Admin | **Filament v5** with TipTap rich editor, Map Picker (Dotswan), Phone Input |
| Media | Spatie MediaLibrary + Filament plugin |
| i18n | Spatie Laravel Translatable + Filament Translatable plugin |
| Internal | `synapps/filament` (in-house Filament components) |
| Deploy | Docker → Dokploy |

## Local dev

```bash
cp .env.example .env
docker compose up -d                  # via Sail or compose
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run dev
```

App at `http://localhost`, admin at `/admin`.

## Required env

| Var | Purpose |
|---|---|
| `COMPOSER_AUTH` | Filament Pro + synapps repo auth (build time) |
| `APP_LOCALE` / `APP_FALLBACK_LOCALE` | SK / EN |

## Deploy

`Dockerfile` two-stage (build → lean runtime). Deployed to Dokploy.

## License

[MIT](LICENSE) © Michal Čečko
